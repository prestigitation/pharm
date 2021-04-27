<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Product;
use App\Models\Dealer;
use App\Models\Status;
use Illuminate\Support\Facades\Storage;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Department::all();
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
        $department = Department::with('name');
        $department = Department::create([
            'city' => $this->formProps->city,
            'address' => $this->formProps->address,
            'chief' => (int) $this->formProps->chief
        ]);
        if($request->hasFile('file')) {
            Storage::putFileAs('./public/img/products/',$request->file('file'),(string) Department::count().'.jpeg');
        }
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
        $department = Department::findOrFail($id);
        $department->update([ // если определенные параметры заданы
            'city' => $this->formProps->city ?? $department->city,
            'address' => $this->formProps->address ?? $department->address,
            'chief' => $this->formProps->chief ?? $department->chief
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
        $department = Department::findOrFail($id);
        $department->delete();
    }


    public function productAdd(Request $request) {
       $this->formProps = json_decode($request->props);
       $departmentInfo= explode(' ',$this->formProps->department_select); // разделяю, чтобы проверить по городу и адресу
       $department = Department::findOrFail((int)$departmentInfo[0]); // получить id филиала

       $productInfo = $this->formProps->product_select;
       $product = Product::where('name',$productInfo)->first();

       $dealerInfo = Dealer::where('company',$this->formProps->dealer_select)->first();
       $statusInfo = Status::where('text',$this->formProps->status_select)->first();

       $department->products()->attach($product->id,[
            'quantity' =>  $this->formProps->quantity,
            'dealer_id' => $dealerInfo->id,
            'status_id' => $statusInfo->id
            ]);

    }
}
