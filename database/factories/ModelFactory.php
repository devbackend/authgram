<?php

use App\Entities\UserEntity;
use Faker\Generator as Faker;

$factory->define(UserEntity::class, function (Faker $faker) {
    static $password;

    return [
        'name'              => $faker->name,
        'email'             => $faker->unique()->safeEmail,
        'password'          => $password ?: $password = bcrypt('secret'),
        'remember_token'    => str_random(10),
    ];
});
