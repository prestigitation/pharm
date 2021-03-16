<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    public function __construct()
    {

    }
    public function create(Request $request) { // POST
        $validator = Validator::make($request->toArray(), [
            'price' => 'integer',
            'contraindications_textarea' => 'nullable',
        ]);
        $categories = Category::with('name');
            $product = Product::create([
                'name' => $this->formProps->name,
                'category' => Category::where('name', $this->formProps->categories)->first()->id,
                'description' => $this->formProps->description,
                'contraindications' => $this->formProps->contraindications ?? null,
                'price' => $this->formProps->price,
                'discount_price' => null
            ]);
            if($request->hasFile('file')) {
                Storage::putFileAs('./public/img/products/',$request->file('file'),(string) Product::count().'.jpeg');
            }
    }
    public function get() {
        return [ 'products' => Product::all()];

    }
    public function update(Request $request) {
        dd($request);
        $product = Product::find($request->updatingId)->first(); // id запрашиваемого дилера
        $product->update([ // если определенные параметры заданы
            'category'=> Category::where('name', $this->formProps->categories)->first()->id,
            'contraindications'=> $this->formProps->contraindications ?? $product->contraindications,
            'description' => $this->formProps->description ?? $product->description,
            'name' => $this->formProps->name ?? $product->name,
            'price' => $this->formProps->price ?? $product->price
        ]);
        if($request->hasFile('file')) {
            Storage::putFileAs('./public/img/departments/',$request->file('file'),(string) $product->id .'.jpeg');
        }
    }
    public function delete(Request $request) {
        $this->__construct();
        $product = Product::find($request->props['deletingId'])->first();
        $product->delete();
    }


    public function getCategories() {
        return Category::all('name');
    }

}
