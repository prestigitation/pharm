<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Storage;

class DepartmentController extends Controller
{
    public function create(Request $request) {
        $formProps = json_decode($request->props);
        Department::create([
            'city' => $formProps->city,
            'address' => $formProps->address
        ]);
        // Секция request => fileBag => files
        if($request->hasFile('files'))
            Storage::putFileAs('./public/img/departments/',$request->formFile,(string) Department::count().'.jpeg');
    }

    public function update() {

    }
}
