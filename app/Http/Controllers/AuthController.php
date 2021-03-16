<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{

    /**
         * Display a listing of the resource.
         *
         * @param  Illuminate\Http\Request $request
         * @return Response
         */
    public function login(Request $request){
        if (Auth::attempt(["name" => $request->login, "password" => $request->password ])) {
            $user = Auth::user();
            return ["user" => $user];
        } else {
            return response()->json(["error" => "Could not log you in"], 403);
        }
    }

    public function register(Request $request) {
        $user = new User();
        $user->name = $request->login;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $user->roles()->attach(2);


        Auth::login($user);

        return ["user" => $user];
    }

    public function logout(Request $request) {
        Auth::logout();
    }
}
