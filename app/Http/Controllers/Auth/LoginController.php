<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
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
    public function __construct(){
    }
    public function login(Request $request){
      $data = $request->all();
      $credentials= ['email'=>$data['email'],'password'=>$data['password']];
      if (auth()->attempt($credentials)) {
        // Authentication passed...
        $user = auth()->user();
        $user->api_token = str_random(60);
        $user->save();
        return redirect('/');
    }

      return back()->withErrors(['email'=> 'Ha ocurrido un error, el usuario o la contraseña son incorrectos']);
    }

    public function LogOut(Request $request){
      return redirect('login')->with(Auth::logout());
    }

}
