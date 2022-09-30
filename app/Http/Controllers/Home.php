<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Home extends Controller
{
    public function index(){
        
        return view('home');
    }

    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        
        return response()->json([$request->username]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),[
                'name'=> 'required|min:3',
                'username'=> 'required|min:3|alpha_dash',
                'password'=> 'required|min:8',
                'number'=> 'required|min:10|numeric'
            ]
            );
            $response = [
                'status'=>false,
                'validation'=>[],
                'message'=>'',
            ];
            if($validator->fails()){
                $response['validation'] = $validator->errors();
                $response['message'] = "Please check your input again!";
                return response()->json($response);
            }
            $username = strtolower($request->username);
            $name = $request->name;
            $number = $request->number;
            $password = $request->password;

            // $userCreate  = User::first();
            $userCreate  = new User;
            $userCreate->name = $name;
            $userCreate->username = $username;
            $userCreate->number = $number;
            $userCreate->password = Hash::make($password);
            $userCreate->save();

            return response()->json(['debug'=>true,$userCreate]);

        // kalau berhasil maka lanjut ke pendaftaran
    }
}
