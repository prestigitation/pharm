<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $props = json_decode($request->props);
        $user = User::findOrFail($id);

        if(!Hash::check($props->previousPassword, $user->password)) { // если пользователь ввел неправильный текущий пароль
            abort(403);
        }
        if($props->editedName!= '') {
            $user->name = $props->editedName;
        }
        if($props->editedEmail!= '') {
            $user->email = $props->editedEmail;
        }
        if($props->editedPassword!= '') {
            $user->password = $props->editedPassword;
        }
        $user->save();

        if($request->hasFile('file')) {
            Storage::putFileAs('./public/img/avatars/',$request->file('file'),(string) $id.'.jpeg');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function rolesGet(Request $request,$id) {
        $user = User::findOrFail($id);
        return $user->roles;
    }

    public function rolesDetach(Request $request,$id) {
        $deletingRole = Role::where('name',$request->deletingRole)->first();
        $user = User::findOrFail($id);
        $user->roles()->detach($deletingRole->id);
    }

    public function rolesAttach(Request $request,$id) {
        $role = Role::where('id',json_decode($request->data['attachingRole']))->first();
        User::find($id)->roles()->attach($role->id);
    }

    public function permissionsGet(Request $request,$id) {
        $result = array();
        $user = User::findOrFail($id);
        $roles = $user->roles;
        foreach($roles as $userRole) {
            if(sizeof($userRole->permissions)>0)
                array_push($result,$userRole->permissions);
        }

        return $result[0];
        // получить все роли, записать в результирующий массив права каждой роли,
        // при этом проверить есть ли уже в массиве определенная роль
    }

    public function changeUserData(Request $request) {
        dd('kek');
    }
}
