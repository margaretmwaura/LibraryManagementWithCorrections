<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RolesPermissionController extends Controller
{

    public function getAllPerms()
    {
        $roles=Role::all();
        $collection = collect([]);
        try{
            $roles->each(function ($item, $key) use ($collection) {

                Log::info($item->id);
                Log::info($item->permissions->pluck('name'));
                $collection->push($item->permissions->pluck('name'));
                Log::info($collection);

            });
        }
        catch (\Exception $e)
        {
            Log::info("The reasons for not getting the collection ".$e->getMessage());
        }
        return response()->json($collection);
    }

    public function assignRoles(Request $request)
    {
       Log::info("The request received " . $request);
       $role=Role::where('name', $request->input('role'))->get();
       $permission=Permission::where('name',$request->input('permission'))->get();
        $id=$permission[0]->id;
       Log::info("The role gotten " .$role[0]);
       Log::info("The permissions gotten " . $permission[0] . " and the id is " . $id );
        try {
            $role[0]->permissions()->attach($id);
            return $this->gettingallrolesnadpermissions();
        }
        catch (\Exception $e)
        {
            Log::info("The error while assinging roles " . $e->getMessage());
        }


    }
    public function detachingrolesandpermissions(Request $request)
    {
        Log::info("The request received " . $request);
        $role=Role::where('name', $request->input('role'))->get();
        $permission=Permission::where('name',$request->input('permission'))->get();
        $id=$permission[0]->id;
        Log::info("The role gotten " .$role[0]);
        Log::info("The permissions gotten " . $permission[0] . " and the id is " . $id );
        try {
            $role[0]->permissions()->detach($id);
            $this->gettingallrolesnadpermissions();
        }
        catch (\Exception $e)
        {
            Log::info("The error while assinging roles " . $e->getMessage());
        }
    }
    public function toggleUserRole(Request $request)
    {
        $id=$request->input("id");
        $newrole=$request->input("role");
        Log::info("The request received in terms of role" . $newrole);
        Log::info("The request received role id of user " . $id);
        $user = User::find($id);

        if($newrole=="ADMIN")
        {
            $roles=\App\Models\Role::where('name','ADMIN')->get();
            $onerole=$roles[0];
            $roles_id = $onerole->id;

            $user->role_id=$roles_id;
            $user->save();
        }
        if($newrole=="USER")
        {
            $roles=\App\Models\Role::where('name','USER')->get();
            $onerole=$roles[0];
            $roles_id=$onerole->id;

            $user->role_id=$roles_id;
            $user->save();
        }
        if($newrole=="NORMAL")
        {

            $roles = \App\Models\Role::where('name','NORMAL')->get();
            $onerole = $roles[0];
            $roles_id = $onerole->id;

            $user->role_id=$roles_id;
            $user->save();
        }


        $users=User::all();
        return response()->json($users);
    }
    public function gettingallrolesnadpermissions()
    {
        $myvar=Role::with("permissions")->get();

        echo $myvar;
    }
}
