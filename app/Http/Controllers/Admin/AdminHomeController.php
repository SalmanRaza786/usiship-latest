<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminHomeController extends Controller
{
    public function index()
    {
        try {

            return view('admin.dashboard');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
