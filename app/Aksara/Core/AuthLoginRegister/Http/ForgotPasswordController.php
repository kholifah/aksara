<?php

namespace App\Aksara\Core\AuthLoginRegister\Http;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Jobs\EmailResetPassword;

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

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showLinkRequestForm()
    {
        $resetPage = \Eventy::filter('aksara.auth-login-register.email.view', get_active_backend_view('auth.passwords.email'));
        return view($resetPage)->render();
    }

    public function sendResetLinkEmail(Request $request)
    { 
        $this->validate($request, ['email' => 'required|email']);

        $user = $this->broker()->getUser(
            $request->only('email')
        );

        if (is_null($user)) {            
            return redirect()->back()->with('message', __('core:auth-login-register::message.user-invalid'));
        } else {
            EmailResetPassword::dispatch($request->only('email'));
            return redirect()->route('admin.login')->with('message', __('core:auth-login-register::message.reset-email-success'));
        }
        
    }
}
