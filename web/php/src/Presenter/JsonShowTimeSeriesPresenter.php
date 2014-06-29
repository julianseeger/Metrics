<?php

namespace Metrics\Web\Presenter;

use Metrics\Core\Presenter\ArrayBased\ArrayBasedShowTimeSeriesPresenter;
use Metrics\Core\Presenter\ShowTimeSeriesPresenter;
use Metrics\Core\ViewDto\ShowTimeSeriesResult;

class JsonShowTimeSeriesPresenter extends ArrayBasedShowTimeSeriesPresenter implements ShowTimeSeriesPresenter
{
    public function present(ShowTimeSeriesResult $result)
    {
        return json_encode(parent::present($result));
    }
}
