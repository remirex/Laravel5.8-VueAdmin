<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserManagementController extends Controller
{
    public function users()
    {
        return UserResource::collection(User::all());
    }
}
