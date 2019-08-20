<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserManagementController extends Controller
{
    public function users()
    {
        $users = User::with('roles')->with('permissions')->get();

        return $users;
    }
}
