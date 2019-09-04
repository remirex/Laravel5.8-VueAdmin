<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{

    public function users()
    {
        return UserResource::collection(User::orderBy('id', 'desc')->paginate(10));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|string|email|min:4|max:300|unique:users',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ]);

        $user= User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> bcrypt($request->password)
        ]);

        if (!isset($roles)) {
            $user->assignRole('guest'); //Assigning role to user
        }

        $roles = $request['role']; //Retrieving the roles field
        //Checking if a role was selected
        if (isset($roles)) {

            foreach ($roles as $role) {
                $role_r = Role::where('id', '=', $role)->firstOrFail();
                $user->assignRole($role_r); //Assigning role to user
            }
        }

        $permissions = $request['permission']; //Retrieving the permission field
        //Checking if a permission was selected
        if (isset($permissions)) {

            foreach ($permissions as $permission) {
                $permission_p = Permission::where('id', '=', $permission)->firstOrFail();
                $user->givePermissionTo($permission_p);
            }
        }

        return response(['message'=>'User Created', 'user'=>$user]);

    }

    public function edit(Request $request, $userID)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|string|email|min:4|max:300'
        ]);

        $user = User::findOrFail($userID);

        $input = $request->only(['name', 'email']); //Retreive the name, email fields

        $user->fill($input)->save();

        $roles = $request['role']; //Retrieving the roles field
        //Checking if a role was selected
        if (isset($roles)) {

            foreach ($roles as $role) {
                $role_r = Role::where('id', '=', $role)->firstOrFail();
                $user->syncRoles($role_r); //Assigning role to user
            }
        }

        $permissions = $request['permission']; //Retrieving the permission field
        //Checking if a permission was selected
        if (isset($permissions)) {

            foreach ($permissions as $permission) {
                $permission_p = Permission::where('id', '=', $permission)->firstOrFail();
                $user->syncPermissions($permission_p);
            }
        }

        return response(['message'=>'User Updated', 'user'=>$user]);
    }

    public function delete($userID)
    {
        User::where('id', $userID)->delete();

        return response(['message'=>'User Updated']);
    }

    public function search()
    {
        if ($search = \Request::get('q')) {
            $users = User::where(function ($query) use ($search){
               $query->where('name', 'LIKE', "%$search%")
                        ->orWhere('email', 'LIKE', "%$search%");
            })->paginate(10);
        } else {
            $users = $this->users();
        }

        return $users;
    }
}
