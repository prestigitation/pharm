<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;

class RolesController extends Controller
{
    public function get(Request $request) {
        return ['roles' => Role::all('name') ];
    }

    public function addRole(Request $request) {
        parent::__construct($request);
        dd($this->formProps);
    }
}
