<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\ResetPasswordNotification;
use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    use Notifiable;

    use SendsPasswordResetEmails;

    private $email;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $rules = array(
            'email' => 'required|exists:users,email'
        );

        $this->validate($request, $rules);

        $email = $request->input('email');

        $this->email = $email;

        $user = User::where('email', $email)->first();

        $token = $this->broker()->createToken($user);

        $this->notify(new ResetPasswordNotification($token, $email));

        return response()->json([
            'message' => 'Password reset email sent.',
            'data' => $this->email
        ]);
    }
}
