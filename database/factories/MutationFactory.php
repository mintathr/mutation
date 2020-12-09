<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Mutation;
use Faker\Generator as Faker;

$factory->define(Mutation::class, function (Faker $faker) {
    return [
        'bank_id' => rand(1, 11),
        'user_id' => rand(1, 2),
        'description' => $faker->sentence(),
        'debit' => rand(0, 700000),
        'credit' => rand(0, 1000000),
        'date' => now(),
    ];
});
