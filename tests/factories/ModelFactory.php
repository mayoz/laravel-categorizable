<?php

use Faker\Generator as Faker;
use Mayoz\Tests\Categorizable\Post;
use Mayoz\Tests\Categorizable\Category;

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

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->unique()->word,
        'slug' => str_slug($name),
        'caption' => $faker->text(255),
    ];
});

$factory->define(Post::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word,
    ];
});
