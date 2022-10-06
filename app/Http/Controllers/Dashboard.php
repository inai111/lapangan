<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    public function merchant_register(Request $request)
    {
        return view('user.merchant-regist');
    }
    public function settingStore(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama'=>'required',
            'number'=>'required|numeric',
            'photo'=>'required',
        ]);
        $response = [
            'status'=>!$validator->fails(),
            'message'=>'Mohon cek kembali pada data yang anda ingin simpan.',
        ];
        if($validator->fails())return response()->json($response);
        $user = User::find(session('userdata')->id);
        $user->name = $request->nama;
        $user->address = $request->address;
        $user->number = $request->number;
        $user->photo = $request->photo;
        $response['status'] = $user->save();
        if($response['status']) $response['message'] = "Data berhasil disimpan";
        return response()->json($response);
    }
}
