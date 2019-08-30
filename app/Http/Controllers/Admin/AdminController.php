<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function roles()
    {
        $roles = Role::all();

        return $roles;
    }

    public function permissions()
    {
        $permissions = Permission::all();

        return $permissions;
    }
}
