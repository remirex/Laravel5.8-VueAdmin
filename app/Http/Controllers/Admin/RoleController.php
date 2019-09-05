<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    private $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function roles()
    {
        return RoleResource::collection(Role::all());
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $role= $this->role->create([
            'name'=> $request->name
        ]);

        $permissions = $request['permission']; //Retrieving the permission field
        //Checking if a permission was selected
        if (isset($permissions)) {
            $role->givePermissionTo(collect($permissions)->pluck('id')->toArray());
        }

        return response(['message'=>'Role Created', 'user' => $role]);
    }

    public function edit(Request $request, $roleID)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $role = $this->role->findOrFail($roleID);

        $input = $request->only(['name']); //Retreive the name fields

        $role->fill($input)->save();

        $permissions = $request['permission']; //Retrieving the permission field
        //Checking if a permission was selected
        if (isset($permissions)) {
            $role->syncPermissions(collect($permissions)->pluck('id')->toArray());
        }

        return response(['message'=>'Role Updated', 'role' => $role]);
    }

    public function delete($roleID)
    {
        $this->role->where('id', $roleID)->delete();

        return response(['message'=>'Role Deleted']);
    }
}
