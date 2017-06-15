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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'image_uri' => 'images/profile.png',
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'location_lat' => $faker->latitude($min = -90, $max = 90),
        'location_lng' => $faker->longitude($min = -180, $max = 180),
        'location' => $faker->address,
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Article::class, function (Faker\Generator $faker) {

    return [
        'title' => $faker->word,
        'image_uri' => 'images/matt-heafy.jpg',
        'body' => $faker->text,
    ];
});
