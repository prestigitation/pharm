<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Product;
use App\Models\Dealer;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DepartmentController extends Controller
{
    public function __construct()
    {

    }
    public function departmentInfo() {
       return  [
        'departments' => Department::all(),
        'products' => Product::all(),
        'dealers' => Dealer::all(),
        'statuses' => Status::all(),
        'storage_path' => public_path()
       ];
    }

    public function productAdd(Request $request) {
        parent::__construct($request);
        $departmentInfo= explode(' ',$this->formProps->department_select); // разделяю, чтобы проверить по городу и адресу
        $department = Department::where('city',$departmentInfo[0])
                                ->where('address',$departmentInfo[1])
                                ->first();

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
    public function create(Request $request) {
        parent::__construct($request);
        Department::create([
            'city' => $this->formProps->city,
            'address' => $this->formProps->address,
            'chief' => $this->formProps->chief
        ]);
        // Секция request => fileBag => files
        // использовать request->file, он тащит определенные файл по индексу, а не сырые файлы
        if($request->hasFile('file')) {
            Storage::putFileAs('./public/img/departments/',$request->file('file'),(string) Department::count().'.jpeg');
        }

    }

    public function update(Request $request) {
        parent::__construct($request);
        $department = Department::find($this->formProps->updatingId)->first(); // id запрашиваемого дилера
        $department->update([ // если определенные параметры заданы
            'city' => $this->formProps->props->city ?? $department->city,
            'address' => $this->formProps->props->address ?? $department->address,
            'chief' => $this->formProps->props->chief ?? $department->chief
        ]);
        $department->save();
        if($request->hasFile('file')) {
            Storage::putFileAs('./public/img/departments/',$request->file('file'),(string) $department->id .'.jpeg');
        }
    }


    public function destroy(Request $request) {
        $this->__construct();
        $department = Department::find($request->props['deletingId'])->first();
        // удаление связанных таблиц происходит в модели
        $department->delete();
    }
}
