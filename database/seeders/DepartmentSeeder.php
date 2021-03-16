<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [ [
            'address'=> 'Ул.Пушкина д.6',
            'chief' => 1,
            'city' => 'Рыбница'
        ],
        [
            'address'=> 'Ул.Ленина д.18',
            'chief' => 1,
            'city' => 'Тирасполь'
        ],
    ];
    foreach($departments as $department) {
        \App\Models\Department::create([
            'address' => $department['address'],
            'chief' => $department['chief'],
            'city' => $department['city'],
        ]);
    }


}


}
