<?php

namespace Metrics\Core\Presenter;

use Metrics\Core\ViewDto\ShowTimeSeriesResult;

class GenericShowTimeSeriesPresenter implements ShowTimeSeriesPresenter
{
    public function present(ShowTimeSeriesResult $result)
    {
        return $result;
    }
}
