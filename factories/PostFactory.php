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
$factory->define(\App\Model\Post::class, function (Faker $faker) {
    return [
        'user_id' => \factory(\App\Model\User::class)->create()->id,
        'category_id' => \factory(\App\Model\Category::class)->create()->id,
        'title' => $faker->sentence,
        'description' => $faker->sentence,
        'headline' => $faker->sentence,
        'image' => $faker->imageUrl(),
        'image_filename' => $faker->sentence,
        'status' => \App\Model\Post::STATUS_PUBLISH,
        'price' => 0,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
