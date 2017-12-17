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
    return [
        'lac'             => random_int(1, 10000),
        'cell_id'         => random_int(1, 10000),
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
    return [
        'lac'             => random_int(1, 10000),
        'cell_id'         => random_int(1, 10000),
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
    return [
        'sid'             => random_int(1, 10000),
        'nid'             => random_int(1, 10000),
        'bid'             => random_int(1, 10000),
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