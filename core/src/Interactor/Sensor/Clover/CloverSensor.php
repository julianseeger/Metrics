<?php

namespace Metrics\Core\Interactor\Sensor\Clover;

use Metrics\Core\Interactor\Sensor\Clover\Dto\Coverage;
use Metrics\Core\Interactor\Sensor\Clover\Dto\File;
use Metrics\Core\Repository\FileRepository;

class CloverSensor
{
    /**
     * @var FileRepository
     */
    private $fileRepository;

    public function __construct(FileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function execute($cloverXml, $project, $version)
    {
        $xml = simplexml_load_string($cloverXml);
        $coverage = Coverage::parse($xml);

        $commonPathPrefix = $this->detectCommonPathPrefix($coverage);

        foreach ($coverage->projects as $cloverProject) {
            foreach ($cloverProject->packages as $cloverPackage) {
                foreach ($cloverPackage->file as $cloverFile) {
                    $filename = str_replace($commonPathPrefix, '', $cloverFile->name);
                    $this->createFile($project, $cloverFile, $filename);
                }
            }
        }

    }

    private function detectCommonPathPrefix($coverage)
    {
        $prefix = null;

        /** @var File $files */
        $files = [];
        foreach ($coverage->projects as $cloverProject) {
            foreach ($cloverProject->packages as $cloverPackage) {
                foreach ($cloverPackage->file as $cloverFile) {
                    $files[] = $cloverFile;
                }
            }
        }

        foreach ($files as $cloverFile) {
            $filepath = trim($cloverFile->name, '/');
            $pathArray = explode('/', $filepath);
            if ($prefix === null) {
                $prefix = $pathArray;
            } else {
                for ($i = 0; $i < count($prefix); $i++) {
                    if (!isset($pathArray[$i]) || $pathArray[$i] != $prefix[$i]) {
                        $prefix = array_slice($prefix, 0, $i);
                        break;
                    }
                }
            }
        }

        return join('/', $prefix);
    }

    /**
     * @param $project
     * @param $cloverFile
     * @param $filename
     */
    public function createFile($project, File $cloverFile, $filename)
    {
        $file = $this->fileRepository->createFile($filename, $project);
        if (isset($cloverFile->class)) {
            $file->setNamespace($cloverFile->class->namespace);
            $file->setClassname($cloverFile->class->name);
        }
    }
}
