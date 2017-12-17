<?php

namespace GL\Http\Controllers\BaseStation;

use GL\Http\Controllers\Controller;

class BaseStationController extends Controller
{
    public function location()
    {
        return $this->json([
            "lat"     => "39.95666122",
            "lon"     => "116.31658628953",
            "radius"  => "100",
            "address" => "北京市海淀区紫竹院街道中广国际新农村;学院南路与中关村南大街路口西北132米"
        ]);
    }
}
