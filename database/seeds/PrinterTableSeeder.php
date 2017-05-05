<?php

use Illuminate\Database\Seeder;

class PrinterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Printer::class, 10)->create();
    }
}
