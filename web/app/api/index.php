<?php

use Metrics\Core\Interactor\ShowProjectsInteractor;
use Metrics\Web\Presenter\JsonShowProjectsPresenter;
use Metrics\Web\Repository\File\FileRepositoryFactory;
use Metrics\Web\Repository\RepositoryFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__ . '/../../../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;
$app->register(
    new Silex\Provider\TwigServiceProvider(),
    array(
        'twig.path' => __DIR__,
    )
);

/** @var RepositoryFactory $repositoryFactory */
$repositoryFactory = new FileRepositoryFactory('/tmp');
$app->get(
    '/',
    function () use ($app) {
        return "hallo!";
    }
);
$app->get(
    '/projects',
    function () use ($repositoryFactory) {
        $presenter = new JsonShowProjectsPresenter();
        $interactor = new ShowProjectsInteractor($repositoryFactory->getProjectRepository(), $presenter);
        return $interactor->execute();
    }
);
$app->post(
    '/projects',
    function (Request $request) use ($repositoryFactory) {
        $content = json_decode($request->getContent());
        $name = $content->name;
        $interactor = new \Metrics\Core\Interactor\AddProjectInteractor($repositoryFactory->getProjectRepository());
        $interactor->execute($name);
        return new Response('', 201);
    }
);
$app->post(
    '/material/{project}/{version}/{materialType}',
    function (Request $request, $project, $version, $materialType) use ($repositoryFactory) {
        if ($request->get('material')) {
            $material = $request->get('material');
        } else if ($request->files->count() > 0) {
            /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $request->files->all()['file'];
            $file->move('/tmp', 'materialupload');
            $material = file_get_contents('/tmp/materialupload');
            unlink('/tmp/materialupload');
        }

        $fileRepository = $repositoryFactory->getFileRepository();
        $fileVersionRepository = $repositoryFactory->getFileVersionRepository();
        $metricsRepository = $repositoryFactory->getMetricsRepository();
        $projectRepository = $repositoryFactory->getProjectRepository();
        $versionRepository = $repositoryFactory->getVersionRepository();

        $interactor = new \Metrics\Core\Interactor\AddMaterialInteractor(
            $fileRepository,
            $fileVersionRepository,
            $metricsRepository,
            $projectRepository,
            $versionRepository
        );
        $interactor->execute($project, $version, $materialType, $material);
        return new Response('', 201);
    }
);

$app->run();
