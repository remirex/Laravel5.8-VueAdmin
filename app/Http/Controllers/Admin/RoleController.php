<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function roles()
    {
        return RoleResource::collection(Role::all());
    }
}
