<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Collection;

use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{
    public function index() {
        return view('layouts.user');
    }

    public function get(Request $request) {
        if(User::where('name',$request->username)->first() != null) {
            return ['user' => User::where('name',$request->username)->get() ];
        } else return response('no users matched',400);
    }

    public function update(Request $request) {
        /*if(User::where('name',$request->username)) {

        } else return response(500);*/
    }

    public function getPermissions(Request $request) {

    }
}
