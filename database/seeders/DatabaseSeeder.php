<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategoriesSeeder::class,
           // DepartmentSeeder::class,
            ProductSeeder::class,
            StatusSeeder::class,
            DealerSeeder::class,
            NewsSeeder::class,
            //OrderSeeder::class
        ]);

    }
}
