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
}
