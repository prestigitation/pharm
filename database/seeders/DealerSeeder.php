<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DealerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dealers = [ [
            'number'=> '2281337',
            'chief' => 'Горин Геннадий Отчествович',
            'company' => 'ВиваФарм'
        ],
    ];
    foreach($dealers as $dealers) {
        \App\Models\Dealer::create([
            'number'=> $dealers['number'],
            'chief' => $dealers['chief'],
            'company' => $dealers['company']
        ]);
    }
    }
}
