<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\PermissionResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    private $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function permissions()
    {
        return PermissionResource::collection($this->permission->all());
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $permission = $this->permission->create([
            'name'=> $request->name
        ]);

        return response(['message'=>'Permission Created', 'user' => $permission]);
    }

    public function edit(Request $request, $permissionID)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $permission = $this->permission->findOrFail($permissionID);

        $input = $request->only(['name']); //Retreive the name fields

        $permission->fill($input)->save();

        return response(['message'=>'Permission Updated', 'role' => $permission]);
    }

    public function delete($permissionID)
    {
        $this->permission->where('id', $permissionID)->delete();

        return response(['message'=>'Permission Deleted']);
    }
}
