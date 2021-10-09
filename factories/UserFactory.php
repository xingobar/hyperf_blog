<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Faker\Generator as Faker;
use Hyperf\Database\Model\Factory;

/* @var Factory $factory */
$factory->define(\App\Model\User::class, function (Faker $faker) {
    return [
        'email' => $faker->email,
        'account' => \Hyperf\Utils\Str::random(10),
        'password' => \HyperfExt\Hashing\Hash::make('123456'),
        'avatar' => $faker->imageUrl(),
        'gender' => array_keys(\App\Model\User::$genderMap)[array_rand(array_keys(\App\Model\User::$genderMap))],
        'verified' => true,
        'verified_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
