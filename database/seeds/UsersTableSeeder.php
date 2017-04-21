<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create([
            'email' => 'admin@mail.pt',
            'password' => bcrypt('admin123'),
            'admin' => true,
        ]);

        factory(App\User::class)->create([
            'email' => 'user@mail.pt',
            'password' => bcrypt('user123'),
            'admin' => false
        ]);

        factory(App\User::class)->create([
            'email' => 'blocked@mail.pt',
            'password' => bcrypt('user123'),
            'admin' => false,
            'blocked' => 1,
        ]);

        factory(App\User::class, 3)->create([
            'password' => bcrypt('123'),
            'blocked' => 1 ,
        ]);
    }
}
