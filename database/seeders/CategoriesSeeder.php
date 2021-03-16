<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoriesNames = ['Обезбаливающие', 'Витамины'];
        foreach($categoriesNames as $categoryName) {
            \App\Models\Category::create([
                'name' => $categoryName
            ]);
        }

    }
}
