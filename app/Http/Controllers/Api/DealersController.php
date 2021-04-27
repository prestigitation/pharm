<?php

namespace App\Http\Controllers\Api;

use App\Models\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DealersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Dealer::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->formProps = json_decode($request->props);
            $dealer = Dealer::create([
                'company'=> $this->formProps->company,
                'chief'=> $this->formProps->chief,
                'number' => $this->formProps->number
            ]);
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
        $this->formProps = json_decode($request->props);
        $dealer = Dealer::findOrFail($id);
        $dealer->update([ // если определенные параметры заданы
            'city' => $this->formProps->city ?? $dealer->city,
            'address' => $this->formProps->address ?? $dealer->address,
            'chief' => $this->formProps->chief ?? $dealer->chief
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dealer = Dealer::findOrFail($id);
        $dealer->delete();
    }
}
