<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public $categories;

    public function __construct()
    {
        $this->categories = Category::all();
    }

    public function store(Request $request) { // POST
        $formData = json_decode($request->formProps);

        $validator = Validator::make($request->toArray(), [
            'price' => 'integer',
            'contraindications_textarea' => 'nullable',
        ]);
        $categories = $this->categories;
        if($validator->fails()) {
            return view('create',compact('categories'));
        } else {
            $product = Product::create([
                'name' => $formData->name,
                'category' => Category::where('name', $formData->categories)->first()->id,
                'description' => $formData->description,
                'contraindications' => $formData->contraindications ?? null,
                'price' => $formData->price,
                'discount_price' => null
            ]);

            Storage::putFileAs('./public/img/',$request->formFile,(string) Product::count().'.jpeg');

            return redirect('/')->with('alert','test');

        }





    }
    public function create() { // GET
        $categories = $this->categories;
        return view('create',compact('categories'));
    }
    public function show() {}
    public function update() {}
    public function destroy() {}
    public function edit() {}
}
