<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = [
            [
                'user_id' => 51,
                'product_id' => 1,
                'quantity' => 1,
                'buy_price' => 12,
                'created_at' => '2021-05-27 21:46:09'
            ],
            [
                'user_id' => 51,
                'product_id' => 2,
                'quantity' => 3,
                'buy_price' => 24,
                'created_at' => '2021-05-27 21:46:09'
            ],
            [
                'user_id' => 51,
                'product_id' => 2,
                'quantity' => 7,
                'buy_price' => 15,
                'created_at' => '2021-05-28 21:46:09'
            ],
            [
                'user_id' => 51,
                'product_id' => 2,
                'quantity' => 7,
                'buy_price' => 15,
                'created_at' => '2021-05-29 21:46:09'
            ],

        ];
        foreach($orders as $order) {
            \App\Models\Order::create([
                'user_id' => $order['user_id'],
                'product_id' => $order['product_id'],
                'quantity' => $order['quantity'],
                'buy_price' => $order['buy_price'],
                'created_at' => $order['created_at']
            ]);
        }
    }
}
