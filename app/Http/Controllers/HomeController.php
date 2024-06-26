<?php

namespace App\Http\Controllers;

use App\Notifications\OrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('auth');
//        $this->middleware('auth:admin');
//    }

    public function sendEmail($client,$mailData)
    {
        try {
            $client->notify(new OrderNotification($mailData));
        }catch (\Exception $e) {
            throw $e;
        }
    }


    public function index()
    {
        try {
            if(Auth::guard('admin')->check()) {
                return redirect()->route('admin.dashboard');
            }
            if(Auth::guard('web')->check()) {
                return view('client.screens.home');
            }
            return redirect()->route('login');

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function customLogout()
    {
        try {
            if(Auth::guard('admin')->check()) {
                Auth::logout();
                Session::flush();
                return redirect()->route('admin.login.view');
            }
            if(Auth::guard('web')->check()) {
                Auth::logout();
                Session::flush();
                return redirect()->route('user.index');
            }



        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
