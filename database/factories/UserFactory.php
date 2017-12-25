<?php

use Faker\Generator as Faker;
use App\User;
use App\Catagory;
use App\Product;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'verified' => $verified = $faker->randomElement([User::VERIFIED_USER,User::UNVERIFIED_USER]),
        'verification_token' => $verified == User::VERIFIED_USER ? null : User::generate_token(),
        'admin' => $verified = $faker->randomElement([User::ADMIN_USER,User::REGULAR_USER]),
    ];
});

$factory->define(Catagory::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
    ];
});

$factory->define(Product::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
		    "quantity" => $faker->number_between(1,10),
		    "status" => $faker->randomElement([Product::AVAILABLE_PRODUCT, Product::UNAVAILABLE_PRODUCT]),
		    "image" => $faker->randomElement('1.jpg', '2.jpg', '3.jpg'),
		    "seller_id" => User::all()->random()->id,
    ];
});