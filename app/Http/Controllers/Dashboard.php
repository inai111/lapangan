<?php

namespace App\Http\Controllers;

use App\Models\Booklists;
use App\Models\Merchant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Dashboard extends Controller
{
    public function index()
    {
        $user = User::find(session('id_user'))->first();
        $merchant = $user->merchant()->where('active','in',['approve','suspended'])->first();
        $first_merchant = $user->merchant()->first();
        $data = [
            'user'=>$user,
            'merchant'=>$merchant,
            'first_merchant'=>$first_merchant,
        ];
        return view('user.dashboard',$data);
    }
    public function tesget()
    {
        $merchant = new Merchant;
        $merchant->name_merchant = "asdasd";
        $merchant->address = "asdasd";
        $merchant->number = "asdasd";
        $merchant->active = "deactivated"; //default nya adalah deactived, tunggu admin menyetujui
        $merchant->bank = "asdasd";
        $merchant->bank_number = "asdasd";
        return $merchant->save();
    }
    public function setting(Request $request)
    {
        $user = User::find(session('id_user'))->first();
        $merchant = $user->merchant()->where('active','!=','rejected')->first();
        $data = [
            'userdata'=>$user,
            'merchant'=>$merchant
        ];
        return view('user.setting',$data);
    }
    public function merchant_register_store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name_merchant'=>'required|alpha|unique:merchants,name_merchant',
            'number'=>'required|numeric',
            'bank'=>'required',
            'address'=>'required',
            'bank_number'=>'required|numeric',
        ]);
        $response = [
            'status'=>!$validator->fails(),
            'message'=>"Mohon periksa kembali form yang anda masukkan.",
        ];
        if($validator->fails()){
            $response['form_err'] = $validator->errors();
            // return redirect()->to()->json($response);
            return redirect()->to('/merchant-regist')->withInput()->withErrors($validator->errors());
        }
        $merchant = new Merchant;
        $merchant->name_merchant = strtolower($request->name_merchant);
        $merchant->address = $request->address;
        $merchant->number = $request->number;
        $merchant->active = "pending"; //default nya adalah deactived, tunggu admin menyetujui
        $merchant->bank = $request->bank;
        $merchant->user_id = session('id_user');
        $merchant->bank_number = $request->bank_number;
        $response['message'] = "Data merchant kamu gagal kami proses! Mohon coba kembali di beberapa menit kedepan!";
        if($merchant->save()){
            $response['message'] = "Data merchant kamu telah di terima! Untuk selanjutnya, tunggu hingga admin memproses data kamu!";
        }
        return redirect()->to('/dashboard');
        // return response()->json([$response]);
    }
    public function merchant_register()
    {
        $user = User::find(session('id_user'))->first();
        $merchant = $user->merchant()->where('active','!=','rejected')->first();
        if(!empty($merchant)) return redirect()->to('/dashboard');
        $data = [
            'user'=>$user,
            'merchant'=>$merchant,
        ];
        return view('user.merchant-regist',$data);
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
        $user = User::find(session('id_user'));
        $user->name = $request->nama;
        $user->address = $request->address;
        $user->number = $request->number;
        $user->photo = $request->photo;
        $response['status'] = $user->save();
        if($response['status']) $response['message'] = "Data berhasil disimpan";
        $user = User::find(session('id_user'));
        $request->session()->put('userdata',$user);
        return response()->json($response);
    }
    public function book_lapangan()
    {
        $user = User::find(session('id_user'))->first();
        $booklists = Booklists::where('user_id',$user['id'])->all();
        $data = [
            'user'=>$user,
            'book'=>$booklists,
        ];
        return view('user.user-book',$data);
    }
    public function trans_lapangan()
    {
        $user = User::find(session('id_user'))->first();
        $booklists = Booklists::where('user_id',$user['id'])->get();
        $data = [
            'user'=>$user,
            // 'book'=>$booklists,
        ];
        return view('user.transaction-list',$data);
    }
}
