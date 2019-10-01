<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Return where after login
     * @return string
     */
    public function authenticated()
    {
        // User role
        $role = Auth::user()->hasRole('admin');
        // Active user
        $userStatus = Auth::user()->status;

        // Check user role
        if ($role and $userStatus == 'Active') {
            return 'admin';
        } elseif ($userStatus == 'Active') {
            return 'home';
        } else {
            return 'error';
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
