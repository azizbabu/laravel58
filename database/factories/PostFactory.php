<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    $dt = $faker->dateTimeBetween($startDate = '-3 months', $endDate = 'now');
    $date = $dt->format("Y-m-d"); // 1994-09-24
    
    return [
        'user_id'   => 1,
        'title' => $faker->sentence($nbWords = 10),
        'type' => $faker->numberBetween($min = 1, $max = 3),
        'content' => $faker->paragraph($nbSentences = 15),
        'post_date' => $date,
    ];
});
