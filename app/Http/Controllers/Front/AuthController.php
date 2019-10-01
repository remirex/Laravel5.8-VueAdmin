<?php

namespace App\Http\Controllers\Front;

use App\Notifications\AccountActivation;
use App\Notifications\SuccessActivation;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class AuthController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function userRegister(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|string|email|min:4|max:300|unique:users',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ]);

        $input = $request->all();

        $input['password'] = bcrypt($input['password']);
        $input['status'] = 'Pending Approval';
        $input['activation_token'] = str_random(60);
        $user = $this->user->create($input);

        $user->assignRole('guest'); //Assigning role to user

        // Send activate notification
        $user->notify(new AccountActivation($user));

        return $user;
    }

    public function userLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = request(['email', 'password']);
        $credentials['status'] = 'Active';

        if (Auth::attempt($credentials) and Auth::user()->hasRole('guest')) {
            return response('home');
        } elseif (Auth::attempt($credentials) and Auth::user()->hasRole('admin')) {
            return response('admin');
        } else {
            return response('error');
        }
    }

    public function activationAccount($token)
    {
        $user = $this->user->where('activation_token', $token)->first();

        if (!$user) {
            return redirect('/');
        }

        $user->status = 'Active';
        $user->activation_token = '';
        $user->save();

        Notification::route('mail', $user->email)
            ->notify(new SuccessActivation());

        return redirect('/');
    }
}
