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
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'department_id' => \App\Department::all()->random()->id,
    ];
});

$factory->define(App\Department::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->unique()->word
    ];
});


$factory->define(\App\Printer::class, function (Faker\Generator $faker){
    return [
        'name' => $faker->unique()->word
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    $users = App\User::all();
    $requests = App\Request::all();

    return [
        'user_id' => $users->random()->id,
        'request_id' => $requests->random()->id,
        'comment' => $faker->realText(255),
        'blocked' => 0
    ];
});


$factory->defineAs(App\Comment::class, 'sub-comments', function (Faker\Generator $faker) {
    $users = App\User::all();
    $requests = App\Request::all();
    $comments = App\Comment::all();
    return [
        'user_id' => $users->random()->id,
        'request_id' => $requests->random()->id,
        'comment' => $faker->realText(255),
        'parent_id' => $comments->random()->id,
        'blocked' => 0
    ];
});

$factory->defineAs(App\Comment::class, 'blocked', function (Faker\Generator $faker) {
    $users = App\User::all();
    $requests = App\Request::all();

    return [
        'user_id' => $users->random()->id,
        'request_id' => $requests->random()->id,
        'comment' => $faker->realText(255),
        'blocked' => 1
    ];
});

$factory->defineAs(App\Comment::class, 'subBlocked', function (Faker\Generator $faker) {
    $users = App\User::all();
    $requests = App\Request::all();
    $comments = App\Comment::all();

    return [
        'user_id' => $users->random()->id,
        'request_id' => $requests->random()->id,
        'comment' => $faker->realText(255),
        'parent_id' => $comments->random()->id,
        'blocked' => 1
    ];
});


$factory->define(App\Request::class, function (Faker\Generator $faker) {
    $printers = \App\Printer::all();
    $users = \App\User::all();

    return [
        'owner_id' => $users->random()->id,
        'printer_id' => $printers->random()->id,
        'status' => $faker->randomDigit,
        'open_date' => $faker->dateTime,
        'due_date' => $faker->dateTime,
        'description' => $faker->realText(255),
        'quantity' => $faker->randomDigit,
        'colored' => $faker->boolean(),
        'file' => $faker->realText(255),
        'stapled' => $faker->boolean(),
        'paper_size' => $faker->randomDigit,
        'paper_type' => $faker->randomDigit,
        'front_back' => $faker->boolean(),
    ];
});
