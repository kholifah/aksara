<?php
namespace App\Aksara\Core\AuthLoginRegister\Http;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

//menambahkan request
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'role' => 'in:admin,editor,author'
        ]);
    }

    public function login(Request $request)
    {
        $loginPage = \Eventy::filter('aksara.auth-login-register.login.view', get_active_backend_view('auth.login'));
        return view($loginPage)->render();
    }

    //method extends untuk mengecek apakah akun sudah aktif
    public function authenticate(Request $request)
    {
        $this->validate($request, [
          'email' => 'required',
          'password' => 'required'
        ]);

        $credential = $request->only(['email','password']);

        if (\Auth::attempt($credential)) {
            if(!\Auth::user()->active){
              \Auth::logout();
              return redirect()->route('admin.login')->with('message', __('core:auth-login-register::message.user-non-active'));
            }
            return redirect()->route('admin.root');
        } else {
            return redirect()->route('admin.login')->with('message', __('core:auth-login-register::message.login-fail'));
        }
    }

    public function logout()
    {
        \Auth::logout();
        return redirect()->route('admin.login')->with('message', __('core:auth-login-register::message.logout-success'));
    }
}
