<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Product;
use App\Models\Department;
use App\Models\Status;
use App\Models\Dealer;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    public $formProps;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::all();
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
       //dd(json_decode($this->formProps));
        $validator = Validator::make($request->toArray(), [
            'price' => 'integer',
            'contraindications_textarea' => 'nullable',
        ]);
        $categories = Category::with('name');
            $product = Product::create([
                'name' => $this->formProps->name,
                'category' => Category::where('name', $this->formProps->categories)->first()->name,
                'description' => $this->formProps->description,
                'contraindications' => $this->formProps->contraindications ?? null,
                'price' => $this->formProps->price,
                'discount_price' => null
            ]);
            if($request->hasFile('file')) {
                Storage::putFileAs('./public/img/products/',$request->file('file'),(string) Product::count().'.jpeg');
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
        return Product::findOrFail($id);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $this->formProps = json_decode($request->props);
        /*dd($this->formProps);*/
        $product = Product::findOrFail($id); // id запрашиваемого дилера
        if(isset($this->formProps->categories)) {
            $categoryName = Category::where('name',$this->formProps->categories)->first()->name;
        }
         else $categoryName = $product->category;
        $product->update([ // если определенные параметры заданы
            'category' =>  $categoryName,
            'contraindications'=> $this->formProps->contraindications ?? $product->contraindications,
            'description' => $this->formProps->description ?? $product->description,
            'name' => $this->formProps->name ?? $product->name,
            'price' => $this->formProps->price ?? $product->price
        ]);
        if($request->hasFile('file')) {
            $fileController = new FileController();
            $fileController->updateFile($request,'products',$id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
    }

    public function getDepartments(Request $request, $id) {
        $resultArray = new Collection();
        $product = Product::find($id);
        $departments = DB::table('department_product')->where('product_id',$id)->get('department_id')->unique('department_id')->toArray();
        foreach($departments as $department) {
           $resultArray->push(Department::where('id',$department->department_id)
           ->first()
           ->city.' '.Department::where('id',$department->department_id)
           ->first()
           ->address);
        }
        return $resultArray;
    }

    public function find(Request $request) {
        $products = Product::all();
        $result = collect([]);
        foreach($products as $product) { // поиск по части поисковго поля
            if(str_contains($product->name,$request['query'])) {
                $result->push($product);
            }
        }
        return $result;
    }

    public function addOrder(Request $request) {
        foreach(json_decode($request['order']) as $order) {
            $prod = Product::where('name',$order->product)->first();
            $model = DB::table('department_product')
            ->where('product_id',$prod->id)
            ->where('department_id',1);
            $modelQuantity = $model->first('quantity');
            $model->update(['quantity'=> $modelQuantity->quantity - $order->quantity]); // инициализация заказа,
            // убираем товары со склада

            Order::create([
                'user_id' => $request->user,
                'product_id' => $prod->id,
                'quantity' => $order->quantity,
                'buy_price' => $prod->price
            ]);
            //добавляем в список заказов
        }
    }
    public function filter(Request $request) {
        $filterData = json_decode($request->filter);
        $result = [];
        if(count($filterData->categories) > 0) {
            foreach($filterData->categories as $category) {
                array_push($result,Product::where('category',$category)->get());
            }
        }
        if(isset($filterData->search) && $filterData->search != '') {
            array_push($result,Product::whereRaw("name LIKE CONCAT('%','".$filterData->search."','%')")->get());
            // поиск по подстроке
        }
        if(isset($filterData->price) && $filterData->price != '' && gettype($filterData->price)=='integer') {
            array_push($result,Product::where('price','<=',$filterData->price)->get());
        }
        return $result;
    }
    public function makeOrder(Request $request, $id) {
        $prod = Product::findOrFail($id);
        Order::create([
            'user_id' => $request->user_id,
            'product_id' => $id,
            'quantity' => 1,
            'buy_price' => $prod->price
        ]);
    }
}
