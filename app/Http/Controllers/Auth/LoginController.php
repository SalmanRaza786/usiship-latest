<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }

    public function login(Request $request)
    {
        $input = $request->all();

        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(!$user=User::where('email',$input['email'])->first()){
            $data='Invalid email';
            return view('auth.login')->with(compact('data'));

        }




        if (auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))) {
            return redirect()->route('user.index');
        } else {
            $data='Invalid credentials!';
            return view('auth.login')->with(compact('data'));

        }
    }


    public function showAdminLoginForm()
    {
        return view('auth.admin-login');
    }

    public function adminLogin(Request $request)
    {

        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if(!$admin=Admin::where('email',$request->email)->where('status',1)->first()){
            return redirect()->route('admin.login.view')->with('error', 'Invalid email!');

        }

        if(!$role=Role::where('id',$admin->role_id)->where('status',1)->first()){
            return redirect()->route('admin.login.view')->with('error', 'Role disabled!');
        }

        if (\Auth::guard('admin')->attempt($request->only(['email','password']), $request->get('remember'))){
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.login.view')->with('error', 'Invalid credentials!');

    }


}
