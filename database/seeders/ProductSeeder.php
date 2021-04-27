<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [ [
            'name'=> 'Ундевит',
            'category' => 'Витамины',
            'description' => 'Витаминки',
            'contraindications'=> '',
            'price' => 12
        ],

    ];
    foreach($products as $product) {
        \App\Models\Product::create([
            'name'=> $product['name'],
            'category' => $product['category'],
            'description' => $product['description'],
            'contraindications'=> $product['contraindications'],
            'price' => $product['price']
        ]);
    }
    }
}
