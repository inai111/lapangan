<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use App\Models\Merchant;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Home extends Controller
{
    public function index(){
        
        return view('home');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username'=> 'required|alpha_dash',
            'password'=> 'required',
        ]);
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
        $data = [
            'username'=> $request->username,
            'password'=> $request->password,
        ];
        if(Auth::attempt($data)){
        $userdata = User::where('username','admin')->first();
            $request->session()->regenerate();
            $request->session()->put('id_user',$userdata['id']);
            $request->session()->put('level',$userdata['level']);
            $request->session()->put('username',$userdata['username']);
            $response['message'] = "welcome back {$request->username}, please wait.";
            $response['status'] = true;
            $response['href'] = "/dashboard";
        }else{
            $response['message']="Please check your input, username or password incorect";
        }
        return response()->json($response);
    }

    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),[
                'name'=> 'required|min:3',
                'username'=> 'required|min:3|alpha_dash|unique:user,username',
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
            // $userCreate->save();
            $response['status'] = true;
            $response['message'] = "Account has been registered and activated.";

            return response()->json($response);

        // kalau berhasil maka lanjut ke pendaftaran
    }

    public function logout()
    {
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');

    }

    public function fetching_lapangan(Request $request)
    {
        $search = strtolower($request->get('search'));
        $search_arr = explode(':',$search);
        $sort_by = $request->get('sort')=="newest"?"DESC":"ASC";
        $query_to = !empty($search_arr[1])?$search_arr[1]:"";
        switch($query_to){
            case "merchant":
                $merchant = Merchant::orderBy('id',$sort_by)->where('name_merchant','like',"%$search_arr[0]%");
                $merchant = $merchant->take(6)->get();
                $result = $merchant;
                break;
            case "lapangan":
                $lapangan = Lapangan::orderBy('id',$sort_by)->where('nama','like',"%$search_arr[0]%");
                $lapangan = $lapangan->take(6)->get();
                $result = $lapangan;
                break;
            default:
                    $merchant = Merchant::orderBy('id',$sort_by)->where('name_merchant','like',"%$search_arr[0]%");
                    $merchant = $merchant->take(3)->get()->toArray();
                    $lapangan = Lapangan::orderBy('id',$sort_by)->where('nama','like',"%$search_arr[0]%");
                    $lapangan = $lapangan->take(3)->get()->toArray();
                    $result = array_merge($merchant,$lapangan);
                break;
        }
        $response = [
            'result'=>$result
        ];
        return response()->json($response);
    }
}
