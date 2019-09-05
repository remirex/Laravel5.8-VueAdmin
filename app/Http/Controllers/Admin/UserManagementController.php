<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserManagementController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function users()
    {
        return UserResource::collection($this->user->orderBy('id', 'desc')->paginate(10));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|string|email|min:4|max:300|unique:users',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ]);

        $user= $this->user->create([
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
            $user->assignRole(collect($roles)->pluck('id')->toArray());
        }

        $permissions = $request['permission']; //Retrieving the permission field
        //Checking if a permission was selected
        if (isset($permissions)) {
            $user->givePermissionTo(collect($permissions)->pluck('id')->toArray());
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
            $user->syncRoles(collect($roles)->pluck('id')->toArray());
        }

        $permissions = $request['permission']; //Retrieving the permission field
        //Checking if a permission was selected
        if (isset($permissions)) {
            $user->syncPermissions(collect($permissions)->pluck('id')->toArray());
        }

        return response(['message'=>'User Updated', 'user'=>$user]);
    }

    public function delete($userID)
    {
        User::where('id', $userID)->delete();

        return response(['message'=>'User Deleted']);
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
