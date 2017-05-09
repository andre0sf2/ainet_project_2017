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
        $departments = [
            'Ciências Jurídicas',
            'Ciências da Linguagem',
            'Engenharia do Ambiente',
            'Engenharia Civil',
            'Engenharia Eletrotécnica',
            'Engenharia Informática',
            'Engenharia Mecânica',
            'Gestão e Economia',
            'Matemática'
        ];
        foreach ($departments as $department){
            factory(\App\Department::class)->create([
                'name' => $department,
            ]);
        }
    }
}
