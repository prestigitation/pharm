<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Faker\Provider\ar_JO\Person;

class RolesController extends Controller
{
    public $formProps;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Role::all();
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
        Role::create([
            'name' => json_decode($this->formProps),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd($id);
    }

    public function permissionsGet($name) {

        $a = Role::where('name',$name)->first();
        //DB::table('roles_permissions')::where()
        return $a->permissions;
        //return User::findOrFail($id)->roles()->permissions();
    }

    public function permissionsAttach(Request $request, $name) {
        $role = Role::where('name',$name)->first();
        $permission = Permission::where('name', $request->selectedPermission)->first();
        if(!Role::hasPermission($role,$permission))
            $role->permissions()->attach($permission->id);
        else abort(404,'Право уже существует');
    }

    public function permissionsDetach(Request $request,$name) {
        $detachingPermission = Permission::where('name',$request->deletingPermission)->first();
        $role = Role::where('name',$name)->first();
        $role->permissions()->detach($detachingPermission->id);
    }
}
