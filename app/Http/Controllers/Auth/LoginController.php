<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
    protected $redirectTo = '/short';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
        $field = filter_var($request->input($this->username()), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $request->merge([$field => $request->input($this->username())]);
        return $request->only($field, 'password');
    }

    public function username()
    {
        return 'username';
    }

    public function login(Request $request)
    {
        //echo "hello";exit();

          $userNameOrEmail = $request->input('username');
          $password = $request->input('password');

          //TODO if missing stuff or validated bla bla

          //ASSUME THAT USERNAME WAS SUPPLIED

          $user = User::where('username',$userNameOrEmail)->first();

          if($user){ //we found the user with the supplied username.

               if(password_verify($password, $user->password)){
                   Auth::loginUsingId($user->id);
                   return redirect('/')->with('status','Login Successful');

               }else {
                   return redirect('/')->with('status','incorrect password');

               }

            }


          //user with that USERNAME was not found

          //so check with email

          $user = User::where('email',$userNameOrEmail)->first();
          if($user){

           //same as for username case
              if(password_verify($password, $user->password)){
                  Auth::loginUsingId($user->id);
                  //return true;
                  return redirect('/')->with('status','Login Successful');

              }else {
                  return redirect('/')->with('status','incorrect password');
                  //return false;
              }

          }
return false;

          //if we get here then the users email or username was not found
          //return with "Username or email  not found"





    }
}
