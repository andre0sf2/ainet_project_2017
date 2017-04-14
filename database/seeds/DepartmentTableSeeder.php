<?php

use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Department::class)->create([
            'name' => 'CleanPrint',
        ]);

        factory(\App\Department::class)->create([
            'name' => 'IPrint',
        ]);

        factory(\App\Department::class)->create([
            'name' => 'LowPrint',
        ]);

        factory(\App\Department::class)->create([
            'name' => 'FastPrint',
        ]);
    }
}
