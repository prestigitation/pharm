<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dealer;

class DealerController extends Controller
{
    public function __construct()
    {

    }
    public function add(Request $request) {
        Dealer::create([
            'company' => $this->formProps->company,
            'number' => $this->formProps->number,
            'chief' => $this->formProps->chief
        ]);
    }

    public function update(Request $request) {
        $dealer = Dealer::find($request->updatingId)->first(); // id запрашиваемого дилера
        $dealer->update([ // если определенные параметры заданы
            'company' => $this->formProps->company ?? $dealer->company,
            'number' => $this->formProps->number ?? $dealer->number,
            'chief' => $this->formProps->chief ?? $dealer->chief
        ]);
    }

    public function get() {
        return ['dealers' => Dealer::all()];
    }

    public function delete(Request $request) {
        $this->__construct();
        $dealer = Dealer::find($request->props['deletingId'])->first();
        $dealer->delete();
    }
}
