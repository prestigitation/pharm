<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function create(Request $request) {
        //dd($request->form);
        Department::create([
            'city' => $request->city,
            'address' => $request->address
        ]);
    }

    public function update() {

    }
}
