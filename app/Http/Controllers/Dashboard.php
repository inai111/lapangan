<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function index(Request $request)
    {
        return view('user.dashboard');
    }
    public function setting(Request $request)
    {
        return view('user.setting');
    }
}
