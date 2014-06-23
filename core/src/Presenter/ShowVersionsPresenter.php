<?php

namespace Metrics\Core\Presenter;

use Metrics\Core\Entity\Version;

interface ShowVersionsPresenter
{
    /**
     * @param Version[] $versions
     * @return mixed
     */
    public function present(array $versions);
}
 