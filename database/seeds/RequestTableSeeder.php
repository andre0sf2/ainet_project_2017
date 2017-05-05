<?php

use Illuminate\Database\Seeder;

class RequestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Request::class, 10)->create();

        factory(App\Comment::class, 15)->create();
        factory(App\Comment::class, 'sub-comments', 15)->create();

        factory(\App\Comment::class, 'blocked', 5)->create();
        factory(\App\Comment::class, 'subBlocked', 5)->create();
    }
}
