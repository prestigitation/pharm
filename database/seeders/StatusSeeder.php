<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = ['Заказано','В пути','Доставлено'];
        foreach($statuses as $status) {
            \App\Models\Status::create([
                'text' => $status
            ]);
        }
    }
}
