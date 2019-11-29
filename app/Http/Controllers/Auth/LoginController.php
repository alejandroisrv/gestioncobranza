<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
    public function login(Request $request){
      $data = $request->all();
      $credentials= ['email'=>$data['email'],'password'=>$data['password']];
      if (auth()->attempt($credentials)) {
        $user = auth()->user();
        $user->load(['sucursal','rol']);
        $user->api_token = Str::random(60);
        $user->save();
        return response()->json(['response' => true,'user'=> $user]);
      }
      return response()->json(['error'=> 'Los datos son incorrectos']);
    }

    public function LogOut(Request $request){
      return redirect('login')->with(Auth::logout());
    }

}
