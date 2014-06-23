<?php

namespace Metrics\Web\Presenter;

use Metrics\Core\Entity\Version;
use Metrics\Core\Presenter\ShowVersionsPresenter;

class JsonShowVersionsPresenter implements ShowVersionsPresenter
{

    /**
     * @param Version[] $versions
     * @return mixed
     */
    public function present(array $versions)
    {
        return json_encode($this->getVersionDtos($versions));
    }

    private function getVersionDtos($versions)
    {
        $dtos = [];

        foreach ($versions as $version) {
            $dtos[] = $this->getVersionDto($version);
        }

        return $dtos;
    }

    private function getVersionDto(Version $version)
    {
        return [
            'label' => $version->getLabel()
        ];
    }
}
