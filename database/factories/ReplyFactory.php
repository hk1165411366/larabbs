<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Reply::class, function (Faker $faker) {

    $time = $faker->dateTimeThisMonth();
    $user_ids = \App\Models\User::all()->pluck('id')->toArray();
    $topic_ids = \App\Models\Topic::all()->pluck('id')->toArray();
    return [
        'content' => $faker->text(),
        'user_id' => $faker->randomElement($user_ids),
        'topic_id' => $faker->randomElement($topic_ids),
        'created_at' => $time,
        'updated_at' => $time,
    ];
});
