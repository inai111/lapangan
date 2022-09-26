<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Home extends Controller
{
    public function index(){
        
        return view('home');
    }

    public function login(Request $request)
    {
        $username = $request->username;
        $passoword = $request->password;
        return response()->json([$request->username]);
    }
}
