<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = [];
        foreach(range(0,30) as $data) {
            $orderData = Order::whereDate('created_at','=',Carbon::now()->subDays($data));
            $created = Order::whereDate('created_at','=',Carbon::now()->subDays($data))->first()->created_at ?? Carbon::now()->subDays($data);
            array_push($result,[
                'quantity' => (int) $orderData->sum('quantity'),
                'created_at' => $created,
            ]);
        }
        return $result;
    }

    /**
     * Display a listing of sales.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSales() {
        $result = [];
        foreach(range(0,30) as $data) {
            $tmp = 0; // врем. переменная для хранения результата умножения цены на количество
            $created = Order::whereDate('created_at','=',Carbon::now()->subDays($data))->first()->created_at ?? Carbon::now()->subDays($data);
            $orderData = Order::whereDate('created_at','=',Carbon::now()->subDays($data));
            foreach($orderData->get() as $data) {
                $tmp += $data->quantity * $data->buy_price;
            }
            array_push($result,[
                'sales' => $tmp,
                'created_at' => $created,
            ]);
        }
        return $result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
