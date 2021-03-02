<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Storage;

class DepartmentController extends Controller
{
    public function create(Request $request) {
        $formData = json_decode($request->formProps);
        Department::create([
            'city' => $formData->city,
            'address' => $formData->address
        ]);
            Storage::putFileAs('./public/img/departments/',$request->formFile,(string) Department::count().'.jpeg');
    }

    public function update() {

    }
}
