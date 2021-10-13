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
$factory->define(\App\Model\Category::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
