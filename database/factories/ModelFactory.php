<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

//================================================================
//                        China Mobile
//================================================================
$factory->define(\GL\Models\BaseStation\ChinaMobile::class, function (Faker\Generator $faker) {
    $lac    = random_int(1, 10000);
    $cellId = random_int(1, 10000);
    return [
        'key'             => sprintf('%s-%s', $lac, $cellId),
        'lac'             => $lac,
        'cell_id'         => $cellId,
        'lat'             => 30.85,
        'lon'             => 106.78,
        'radius'          => 120,
        'more_info'       => json_encode([
            'province' => '四川省',
            'city'     => '成都市',
            'district' => '龙泉驿区',
            'township' => '龙泉街道',
            'address'  => '四川省成都市龙泉驿区龙泉街道百工堰村;枇杷沟路与公园路路口南812米',
        ]),
        'data_refresh_at' => \Carbon\Carbon::now()->subDays(20),
    ];
});

//================================================================
//                        China Unicom
//================================================================
$factory->define(\GL\Models\BaseStation\ChinaUnicom::class, function (Faker\Generator $faker) {
    $lac    = random_int(1, 10000);
    $cellId = random_int(1, 10000);
    return [
        'key'             => sprintf('%s-%s', $lac, $cellId),
        'lac'             => $lac,
        'cell_id'         => $cellId,
        'lat'             => 30.85,
        'lon'             => 106.78,
        'radius'          => 120,
        'more_info'       => json_encode([
            'province' => '四川省',
            'city'     => '成都市',
            'district' => '龙泉驿区',
            'township' => '龙泉街道',
            'address'  => '四川省成都市龙泉驿区龙泉街道百工堰村;枇杷沟路与公园路路口南812米',
        ]),
        'data_refresh_at' => \Carbon\Carbon::now()->subDays(20),
    ];
});

//================================================================
//                        China Telecom
//================================================================
$factory->define(\GL\Models\BaseStation\ChinaTelecom::class, function (Faker\Generator $faker) {
    $sid = random_int(1, 10000);
    $nid = random_int(1, 10000);
    $bid = random_int(1, 10000);
    return [
        'key'             => sprintf('%s-%s-%s', $sid, $nid, $bid),
        'sid'             => $sid,
        'nid'             => $nid,
        'bid'             => $bid,
        'lat'             => 30.85,
        'lon'             => 106.78,
        'radius'          => 120,
        'more_info'       => json_encode([
            'province' => '四川省',
            'city'     => '成都市',
            'district' => '龙泉驿区',
            'township' => '龙泉街道',
            'address'  => '四川省成都市龙泉驿区龙泉街道百工堰村;枇杷沟路与公园路路口南812米',
        ]),
        'data_refresh_at' => \Carbon\Carbon::now()->subDays(20),
    ];
});

//================================================================
//                       Base Station
//================================================================
$factory->define(\GL\Models\BaseStation\BaseStation::class, function (Faker\Generator $faker) {
    $sid = random_int(1, 10000);
    $nid = random_int(1, 10000);
    $bid = random_int(1, 10000);
    return [
        'id'  => sprintf('%s-%s-%s', $sid, $nid, $bid),
        'mnc' => $sid,
        'lac' => $nid,
        'cid' => $bid,
        'lat' => 30.85,
        'lng' => 106.78,
    ];
});