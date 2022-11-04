<?php

namespace App\Http\Controllers;

use App\Models\Booklists;
use App\Models\Gallery;
use App\Models\Lapangan;
use App\Models\Merchant;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class Dashboard extends Controller
{
    public function index()
    {
        $user = User::where('id',session('id_user'))->first();
        $merchant = $user->merchant;
        $data = [
            'user' => $user,
            'merchant' => $merchant,
        ];
        return view('user.dashboard', $data);
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
    public function setting($param = null)
    {
        $user = User::where('id',session('id_user'))->first();
        $merchant = $user->merchant()->where('active', '!=', 'rejected')->first();
        $data = [
            'userdata' => $user,
            'merchant' => $merchant
        ];
        // jika ada data merchant dan ada parameter 1 maka akan diarahkan ke halaman merchant
        if(!empty($param) && $param == 1 && !empty($merchant) && !in_array($merchant->active,['pending','rejected'])) return view('user.setting-merchant', $data);
        return view('user.setting', $data);
    }
    public function merchant_register_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_merchant' => 'required|alpha|unique:merchants,name_merchant',
            'number' => 'required|numeric',
            'bank' => 'required',
            'address' => 'required',
            'bank_number' => 'required|numeric',
            'open' => 'required',
            'close' => 'required',
        ]);
        
        $response = [
            'status' => !$validator->fails(),
            'message' => "Mohon periksa kembali form yang anda masukkan.",
        ];
        if ($validator->fails()) {
            $response['form_err'] = $validator->errors();
            // return redirect()->to()->json($response);
            return redirect()->to('/merchant-regist')->withInput()->withErrors($validator->errors());
        }
        $open = strtotime($request->post('open'));
        $close = strtotime($request->post('close'));
        if($open > $close) return redirect()->back()->withInput()->with("failed-message","Gagal Menyimpan!, Waktu tutup lebih awal dari waktu buka");
        $merchant = Merchant::where('user_id',session('id_user'))->first();
        if(!$merchant) $merchant = new Merchant;
        $merchant->name_merchant = strtolower($request->name_merchant);
        $merchant->address = $request->address;
        $merchant->number = $request->number;
        $merchant->active = "pending"; //default nya adalah deactived, tunggu admin menyetujui
        $merchant->bank = $request->bank;
        $merchant->user_id = session('id_user');
        $merchant->bank_number = $request->bank_number;
        $response['message'] = "Data merchant kamu gagal kami proses! Mohon coba kembali di beberapa menit kedepan!";
        if ($merchant->save()) {
            $response['message'] = "Data merchant kamu telah di terima! Untuk selanjutnya, tunggu hingga admin memproses data kamu!";
        }
        return redirect()->to('/dashboard');
        // return response()->json([$response]);
    }
    public function merchant_register()
    {
        $user = User::where('id',session('id_user'))->first();
        $merchant = $user->merchant;
        if (!empty($merchant) && $merchant['active'] != 'rejected') return redirect()->to('/dashboard');
        $data = [
            'user' => $user,
            'merchant' => $merchant,
        ];
        return view('user.merchant-regist', $data);
    }
    public function settingStore($param = null, Request $request)
    {
        // untuk menyimpan data update merchant
        if(!empty($param) && $param == 1){
            $user = User::where('id',session('id_user'))->first();
            $merchant = $user->merchant;
            if(!empty($merchant) && !in_array($merchant->active,['pending','rejected'])) 
            {
                $validator = Validator::make($request->all(), [
                    'address' => 'required',
                    'number' => 'required|numeric',
                    'bank' => 'required',
                    'bank_number' => 'required|numeric',
                    'open' => 'required',
                    'close' => 'required',
                ]);
                $open = strtotime($request->post('open'));
                $close = strtotime($request->post('close'));
                if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator->errors());
                if($open > $close) return redirect()->back()->withInput()->with("failed-message","Gagal Menyimpan!, Waktu tutup lebih awal dari waktu buka");
                $merchant->address = $request->post('address');
                $merchant->number = $request->post('number');
                $merchant->bank = $request->post('bank');
                $merchant->bank_number = $request->post('bank_number');
                $merchant->open = date("H:00:00",strtotime($request->post('open')));
                $merchant->close = date("H:00:00",strtotime($request->post('close')));
                if($merchant->save()) return redirect()->back()->with('success-message','Data Berhasil Diupdate');
                return redirect()->back()->with('failed-message','Data Gagal Berhasil Diupdate');
            }
        }
        // untuk menyimpan data update user
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'number' => 'required|numeric',
            'photo' => 'required',
        ]);
        $response = [
            'status' => !$validator->fails(),
            'message' => 'Mohon cek kembali pada data yang anda ingin simpan.',
        ];
        if ($validator->fails()) return response()->json($response);
        $user = User::where('id',session('id_user'));
        $user->name = $request->nama;
        $user->address = $request->address;
        $user->number = $request->number;
        $user->photo = $request->photo;
        $response['status'] = $user->save();
        if ($response['status']) $response['message'] = "Data berhasil disimpan";
        $user = User::where('id',session('id_user'));
        $request->session()->put('userdata', $user);
        return response()->json($response);
    }
    public function book_lapangan()
    {
        $user = User::where('id',session('id_user'))->first();
        $booklists = Booklists::where('user_id', $user['id'])->all();
        $data = [
            'user' => $user,
            'book' => $booklists,
        ];
        return view('user.user-book', $data);
    }
    public function trans_lapangan()
    {
        $user = User::where('id',session('id_user'))->first();
        $booklists = Booklists::where('user_id', $user['id'])->get()->all();
        $data = [
            'user' => $user,
            'booklists'=>$booklists,
        ];
        return view('user.transaction-list', $data);
    }
    public function lapangan()
    {
        $user = User::where('id',session('id_user'));
        $merchant = $user->merchant;
        if(!$merchant && in_array($merchant,['rejected','pending'])) return redirect('/merchant-regist');
        $lapangan = $merchant->lapangan;
        $data = [
            'lapangan'=>$lapangan,
            'user'=>$user,
            'merchant'=>$merchant,
        ];
        return view('merchant.list-lapangan');
    }
    public function add_lapangan_store(Request $request)
    {
        // file_put_contents('/assets/img/asdasd.png',$request->cover_lapangan);
        $validator = Validator::make($request->all(), [
            'cover_lapangan' => 'required',
            'nama_lapangan' => 'required',
            'harga' => 'required',
            'type_lapangan' => 'required',
        ]);
        if ($validator->fails()) return redirect()->to('/add-lapangan')->withInput()->withErrors($validator->errors());
        $nama_dir = str_replace(' ', '_', $request->nama_lapangan);
        // upload cover lapangan
        if ($request->cover_lapangan) {
            $request->cover_lapangan->store("/img/$nama_dir/cover/", ['disk' => 'public']);
        }

        $lapangan = new Lapangan();
        $lapangan->nama = $request->nama_lapangan;
        $lapangan->harga = $request->harga;
        $lapangan->type = $request->type_lapangan;
        $lapangan->additional_info = $request->additional_info;
        $lapangan->cover = $request->cover_lapangan->hashName();
        $lapangan->save();
        $gallery = [];
        if ($request->gallery) {
            foreach ($request->gallery as $i => $file) {
                $file->store("/img/$nama_dir/", ['disk' => 'public']);
                $gallery[] = [
                    "photo" => $file->hashName(),
                    "ref_id" => $lapangan->id,
                    "created_at" => date("Y-m-d H:i:s"),
                ];
            }
        }
        if ($gallery)Gallery::insert($gallery);
        return redirect()->to('/merchant-lapangan');
    }
    public function lapangan_store(Request $request)
    {
        return view('merchant.lapangan');
    }
    public function merchant_list(Request $request)
    {
        $search = $request->get('search')?:"";
        $status = in_array($request->get('status'),['pending','active','suspended','rejected','all'])?$request->get('status'):'';
        $merchant = Merchant::where('name_merchant','like',"%$search%");
        switch($status){
            case "all":
                break;
            case "":
                $merchant = $merchant->whereIn('active',['active','pending']);
                break;
            default:
                $merchant = $merchant->where('active',$status);
                break;
        }
        $merchant = $merchant->paginate();
        $data = [
            'merchants'=>$merchant
        ];
        return view('admin.list-merchant',$data);
    }
    public function merchant_status_change(Request $request)
    {
        $user = User::where('id',session('id_user'))->first();
        if($user['level']!='admin')return response()->json('mana boleh di akses',400);
        $id = $request->post('id_merchant');
        $status = $request->post('status');
        $merchant = Merchant::find($id)->first();
        $merchant->active = $status;
        return response()->json($merchant->save());
    }
    public function add_transaction($id,Request $request)
    {
        $lapangan = Lapangan::find($id)->first();
        $length = $request->get('length');
        $length = (int)$length>0?$length:1;
        $user = User::where('id',session("id_user"));
        $booklist = new Booklists();
        $booklist->user_id = session('id_user');
        $booklist->lapangan_id = $id;
        $booklist->status = 'pending';
        $booklist->length = $length;
        $response['status'] = false;
        if($booklist->save()){
            $response['status'] = true;
        }
        return response()->json($response);
    }
}
