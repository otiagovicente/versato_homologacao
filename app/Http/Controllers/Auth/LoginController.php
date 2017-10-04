<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    protected $default_password = '12345678';
    
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function resetPassword(Request $request)
    {
        $email = $request->email;
        if(env('APP_DEBUG', false) && $this->resetPasswordByEmail($email)) {
            return response()->json(['status' => 'OK']);
        } else {
            return response('', 403);
        }
    }

    public function resetPasswordByEmail($email) {
        $user = \App\User::where('email', $email)->first();
        if($user) {            
            $user->password = \Hash::make($this->default_password);
            $user->save();
            return true;
        } else {
            return false;
        }
    }

}
