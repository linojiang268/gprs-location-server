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
//                         User
//================================================================
//$factory->define(Icar\Models\User\User::class, function (Faker\Generator $faker) {
//    return [
//        'id'         => $faker->uuid,
//        'mobile'     => 1 . rand(10000, 99999) . rand(10000, 99999),
//        'password'   => bcrypt(str_random(10)),
//        'name'       => 'Cuijing',
//        'gender'     => 2,
//        'birth'      => '2016-09-12',
//        'avatar_url' => 'http://avatar_url.jpg',
//        'status'     => \Icar\Models\User\User::STATUS_NORMAL,
//    ];
//});