<?php

namespace Metrics\Core\Presenter;

use Metrics\Core\ViewDto\ShowTimeSeriesResult;

interface ShowTimeSeriesPresenter
{
    public function present(ShowTimeSeriesResult $result);
}
