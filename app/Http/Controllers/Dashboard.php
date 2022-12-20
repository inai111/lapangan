<?php

namespace App\Http\Controllers;

use App\Models\Booking_date;
use App\Models\Booklists;
use App\Models\Gallery;
use App\Models\History_Balance;
use App\Models\Jenis_olahraga;
use App\Models\Lapangan;
use App\Models\Merchant;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Midtrans\Config;
use Midtrans\Transaction;
use Midtrans\Snap;
class Dashboard extends Controller
{
    public function __construct()
    {
        Config::$serverKey = "SB-Mid-server-0PUgUrRzyAhpN0qslKhm01fM";
    }
    public function index()
    {
        $user = User::where('id',session('id_user'))->first();
        $merchant = $user->merchant;
        $pending_merchant = Merchant::where('status_merchant','pending')->get()->all();
        $ongoing_booklist = 0;
        if($user->role == 'merchant'){
            $ongoing_booklist = Booklists::where('status','on_going')->get()->all();
        }
        $history = History_Balance::where('type','pending')->get()->all();
        $request_saldo = count($history);
        $data = [
            'user' => $user,
            'merchant' => $merchant,
            'request_saldo' => $request_saldo,
            'pending_merchant' => $pending_merchant,
            'ongoing_booklist' => $ongoing_booklist,
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
    #settings/num / settings/
    public function setting($param = null)
    {
        $user = User::where('id',session('id_user'))->first();
        $merchant = $user->merchant;
        $data = [
            'userdata' => $user,
            'merchant' => $merchant
        ];
        // jika ada data merchant dan ada parameter 1 maka akan diarahkan ke halaman merchant
        if(!empty($param) && $param == 1 && !empty($merchant) && !in_array($merchant->status_merchant,['pending','rejected'])) return view('user.setting-merchant', $data);
        return view('user.setting', $data);
    }
    public function merchant_register_store(Request $request)
    {
        $merchant = Merchant::where('user_id',session('id_user'))->first();
        $rules = [
            'number' => 'required|numeric',
            'bank' => 'required',
            'address' => 'required',
            'bank_number' => 'required|numeric',
            'open' => 'required',
            'close' => 'required',
        ];
        if(!$merchant) $rules['name_merchant'] = 'required|unique:merchants,nama';
        $validator = Validator::make($request->all(), $rules);
        
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
        if(!$merchant) $merchant = new Merchant;
        $merchant->nama = strtolower($request->name_merchant);
        $merchant->user_id = session('id_user');
        $merchant->alamat = $request->address;
        $merchant->nomor = $request->number;
        $merchant->status_merchant = "pending"; //default nya adalah pending, tunggu admin menyetujui
        $merchant->bank = $request->bank;
        $merchant->norek = $request->bank_number;
        $merchant->buka = $request->open;
        $merchant->tutup = $request->close;
        $merchant->status_ = 'open'; //default
        $merchant->pembayaran = 'both';
        $merchant->dp = 1;
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
    public function settingStore(Request $request,$param = null)
    {
        // untuk menyimpan data update merchant
        $user = User::where('id',session('id_user'))->get()->first();
        if(!empty($param) && $param == 1){
            $merchant = $user->merchant;
            if(!empty($merchant) && !in_array($merchant->status_merchant,['pending','rejected'])) 
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
                $merchant->alamat = $request->post('address');
                $merchant->norek = $request->post('number');
                $merchant->bank = $request->post('bank');
                $merchant->norek = $request->post('bank_number');
                $merchant->buka = date("H:00:00",strtotime($request->post('open')));
                $merchant->tutup = date("H:00:00",strtotime($request->post('close')));
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
        $user->nama = $request->nama;
        $user->alamat = $request->address;
        $user->nomor = $request->number;
        $user->foto = $request->photo;
        $response['status'] = $user->save();
        if ($response['status']) $response['message'] = "Data berhasil disimpan";
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
        $booklists['pending'] = Booklists::where('user_id', $user['id'])->where('status','!=','cancel')->where('status','pending')->get()->all();
        foreach($booklists['pending'] as $key => $book){
            $merchant = Merchant::where('id',$book->lapangan->merchant_id)->first();
            $transaction = Transactions::where('booklists_id',$book->id)->where('status','!=','gagal')->first();
            if(!empty($transaction->midtrans_token)){
                $midtrans_cek = (Object)Transaction::status($transaction->token);
                if($midtrans_cek->status_code == 200 && $midtrans_cek->transaction_status == "settlement"){
                        $transaction->status = 'berhasil';
                        $book->status = 'on_going';
                        $book->tanggal_bayar = date("Y-m-d H:i:s");
                        $book->down_payment = $transaction->total;
                        $transaction->save();
                        $book->save();
                        return $this->trans_lapangan();
                    }
            }
            // kalau sudah punya tanggal dan terakhir update adalah 2 menit, maka ubah 
            // status nya ke cancel
            // if(!empty($book->booking_date->all()) && strtotime('now')>strtotime("+2 minutes {$book->updated_at}") && $book->status != 'on_going'){
            if(!empty($book->booking_date->all()) && strtotime('now')>strtotime("+2 hour {$book->updated_at}") && $book->status != 'on_going'){
                $book->status = 'cancel';
                $book->save();
                return $this->trans_lapangan(); // reload ulang
            }else{
                $booklists['pending'][$key]['jadwal'] = $book->booking_date;
                $booklists['pending'][$key]['dp'] = $merchant->dp;
                $booklists['pending'][$key]['pembayaran'] = $merchant->pembayaran;
                $booklists['pending'][$key]['name_merchant'] = $merchant->name_merchant;
                $booklists['pending'][$key]['id_merchant'] = $merchant->id;
                $booklists['pending'][$key]['transaction'] = $transaction;
            }
        }
        $booklists['ongoing'] = Booklists::where('user_id', $user['id'])->where('status','on_going')->get();
        $booklists['complete'] = Booklists::where('user_id', $user['id'])->where('status','!=','cancel')->where('status','complete')->get();
        $data = [
            'user' => $user,
            'booklists'=>$booklists,
        ];
        return view('user.transaction-list', $data);
    }

    #merchant-lapangan/num
    public function lapangan_ini($id,Request $request)
    {
        $user = User::where('id',session('id_user'))->first();
        $merchant = $user->merchant;
        $lapangan = Lapangan::where('id',$id)->where('merchant_id',$merchant->id)->get()->first();
        $tanggal = $request->get('search');
        $booklist = Booklists::whereHas('booking_date', function($query) use ($tanggal){
            return $query->where('tanggal','=>', $tanggal);
        })->where('lapangan_id', $lapangan->id)->get();
        $booking_date = [];
        if($booklist){
            foreach($booklist as $book){
                if($book->booking_date){
                    foreach($book->booking_date as $bd){
                        $booking_date [] = "{$bd['tanggal']} {$bd['jam']}";
                    }
                }
            }
        }
        $data = [
            'lapangan'=>$lapangan,
            'booking_date'=>$booking_date,
            'user'=>$user,
            'merchant'=>$merchant,
            'tgl'=>$tanggal
        ];
        return view('merchant.jadwal-lapangan',$data);
    }
    public function lapangan()
    {
        $user = User::where('id',session('id_user'))->first();
        $merchant = $user->merchant;
        if(!$user->role == 'merchant') return redirect('/merchant-regist');
        $lapangan = $merchant->lapangan;
        foreach($lapangan as $key=>$item){
            $booklist = Booklists::where('lapangan_id',$item->id)->where('status','complete')->get()->all();
            $rating = 0;
            $total_rating=0;
            if($booklist){
                foreach($booklist as $book){
                    if($book->rating){
                        $total_rating++;
                        $rating += $book->rating;
                    }
                }
                if($total_rating != 0) $rating /= $total_rating;
            }
            $lapangan[$key]['rating'] = $rating;
            $lapangan[$key]['total_rating'] = $total_rating;
            $lapangan[$key]['total_book'] = count($booklist);
        }
        $data = [
            'lapangan'=>$lapangan,
            'user'=>$user,
            'merchant'=>$merchant,
        ];
        return view('merchant.list-lapangan',$data);
    }
    public function add_lapangan_store(Request $request)
    {
        if(session('role')!='merchant') return redirect()->to('/add-lapangan')->withInput()->with("failed-message","Anda bukan seorang merchant");
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
        $merchant = Merchant::where('user_id',session('id_user'))->first();
        $lapangan = new Lapangan();
        $lapangan->merchant_id = $merchant->id;
        $lapangan->jenis_olahraga_id = $request->type_lapangan;
        $lapangan->nama = $request->nama_lapangan;
        $lapangan->harga = $request->harga;
        $lapangan->cover = $request->cover_lapangan->hashName();
        $lapangan->deskripsi = $request->additional_info;
        $lapangan->save();
        $gallery = [];
        if ($request->gallery) {
            foreach ($request->gallery as $i => $file) {
                $file->store("/img/$nama_dir/", ['disk' => 'public']);
                $gallery[] = [
                    "lapangan_id" => $lapangan->id,
                    "photo" => $file->hashName(),
                    "created_at" => date("Y-m-d H:i:s"),
                ];
            }
        }
        if ($gallery)Gallery::insert($gallery);
        return redirect()->to('/merchant-lapangan');
    }
    public function lapangan_store(Request $request)
    {
        $jenis_olahraga = Jenis_olahraga::all();
        $data = [
            'jenis_olahraga' => $jenis_olahraga,
        ];
        return view('merchant.lapangan',$data);
    }
    public function merchant_list(Request $request)
    {
        $search = $request->get('search')?:"";
        $status = in_array($request->get('status'),['pending','active','suspended','rejected','all'])?$request->get('status'):'';
        $merchant = Merchant::where('nama','like',"%$search%");
        switch($status){
            case "all":
                break;
            case "":
                $merchant = $merchant->whereIn('status_merchant',['active','pending']);
                break;
            default:
                $merchant = $merchant->where('status_merchant',$status);
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
        if($user['role']!='admin')return response()->json('mana boleh di akses',400);
        $id = $request->post('id_merchant');
        $status = $request->post('status');
        $merchant = Merchant::where('id',$id)->first();
        $user = User::where('id',$merchant->user_id)->first();
        $user->role = 'merchant';
        $user->save();
        $merchant->status_merchant = $status;

        return response()->json($merchant->save());
    }
    public function add_transaction($id)
    {
        // $lapangan = Lapangan::where('id',$id)->first();
        // $user = User::where('id',session("id_user"));
        $booklist = new Booklists();
        $booklist->user_id = session('id_user');
        $booklist->lapangan_id = $id;
        $booklist->status = 'pending';
        $response['status'] = false;
        if($booklist->save()){
            $response['status'] = true;
        }
        return response()->json($response);
    }

    public function deleting_transaction(Request $request)
    {
        if(empty($request->post('id'))) return redirect()->back()->with("failed-message","Tidak ada transaksi yang dihapus!");
        $booklist = Booklists::where('id',$request->post('id'))->get()->first();
        if(empty($booklist)) return redirect()->back()->with("failed-message","Tidak ada transaksi yang dihapus!");
        $booklist->status = 'cancel';
        $booklist->updated_at = date("Y-m-d H:i:s");
        if($booklist->save()) return redirect()->back()->with("success-message","Tidak ada transaksi yang dihapus!");
        return redirect()->back()->with("failed-message","Tidak ada transaksi yang dihapus!");
    }
    
    public function booking_date(Request $request)
    {
        $response = [
            'status'=>false,
            'message'=>"Jadwal Gagal di booking!"
        ];
        if(empty($request->post('id'))) return response()->json($response);
        $booklist = Booklists::where('id',$request->post('id'))->get()->first();
        if(empty($booklist)) return response()->json($response);
        $hours = explode(',',$request->post('hour'));
        $length = count($hours);
        $date = $request->post('date');
        // update length
        $booklist->length = $length;
        $booklist->total_biaya = $length * $booklist->lapangan->harga;
        if(!$booklist->save()) return response()->json($response);
        // insert booking date
        foreach($hours as $hour){
            $cek = Booklists::whereHas('booking_date', function($query) use ($date,$hour){
                return $query->where('tanggal','=', $date)->where('jam',$hour);
            })->where('lapangan_id', $booklist->lapangan->id)->where('status','!=','cancel')->get()->first();
            // $cek = Booking_date::where('lapangan_id',$booklist['lapangan_id'])->where('jam',$hour)->where('tanggal',$date)->get()->all();
            if(!empty($cek)) return response()->json($response);
            $booking_date = new Booking_date();
            $booking_date->booklists_id = $request->post('id');
            $booking_date->tanggal = $date;
            $booking_date->jam = $hour;
            if(!$booking_date->save()) return response()->json($response);
        }
        $response['status']=true;
        $response['message']="Jadwal Berhasil di booking!";
        return response()->json($response);
    }

    public function checking_transaction(Request $request)
    {
        $response = [
            'status'=>false,
            'token'=>'',
            'message'=>"Tidak ada data."
        ];
        if(!session()->has('id_user')) return response()->json($response);
        $id = $request->get('id');
        $pembayaran = $request->get('pembayaran');
        if(!$id) return response()->json($response);
        $user = User::where('id',session('id_user'))->get()->first();
        $booklist = Booklists::where('id',$id)->get()->first();
        if(!$booklist) return response()->json($response);
        $lapangan = $booklist->lapangan;
        // $lapangan = Lapangan::where('id',$booklist->lapangan_id)->get()->first();
        $merchant = $lapangan->merchant;
        $transaction = Transactions::where('booklists_id',$id)->where('status','!=','gagal')->get()->first();
        $response['message'] = '';
        $total = $lapangan->harga * $booklist->length;
        $transfer = false;
        $pembayaran1 = $pembayaran=='dp'?'both':$pembayaran;
        $beda = $pembayaran1 != $booklist->type_pembayaran;
        switch($pembayaran){
            case "dp":
                $booklist->jenis_pembayaran = 'both';
                $total /= 2;
                $booklist->down_payment = $total;
                $transfer = true;
                break;
            case "full":
                    $booklist->jenis_pembayaran = 'transfer';
                $booklist->down_payment = 0;
                    $transfer = true;
                break;
            case "cash":
                $booklist->jenis_pembayaran = 'cash';
                $booklist->status = 'on_going';
                break;
        }

        if(!$transaction)
        {
            $transaction = new Transactions;
            $transaction->token = "LAP-$id".session('id_user').rand(000000,999999);
            $transaction->status = "pending";
            $transaction->total = $total;
            $transaction->booklists_id = $id;
            
            if($transfer){
                $item_details = array([
                    'id' => $transaction->token,
                    'price' => round($total),
                    'quantity' => 1,
                    'name' => "testing Lapangan"
                ]);
                $transaction_details = array(
                    'order_id' => $transaction->token,
                    'gross_amount' => round($total)
                );
                $customer_details = array(
                    'first_name' => "asdasdzxc",
                    'email' => "lapangankrisna@gmail.com",
                    'phone' => "1231235435",
                );
                $credit_card['secure'] = true;
                $transaction_data = array(
                    'transaction_details'=> $transaction_details,
                    'item_details' => $item_details,
                    'customer_details' => $customer_details,
                    'credit_card' => $credit_card,
                    'whitelist_bins' => [],
                    // 'expiry'             => $custom_expiry
                );
                $midtransTrans = Snap::createTransaction($transaction_data);
                $transaction->midtrans_token = $midtransTrans->token;
            }
            $transaction->save();
        }else{
            if($transaction->midtrans_token){
                $midtrans_cek = (Object)Transaction::status($transaction->token);
                $response['midtrans']=$midtrans_cek;
                // dd($midtrans_cek);
                if($midtrans_cek->status_code == 200 && $midtrans_cek->transaction_status=='cancel'){
                    $transaction->status = 'gagal';
                    $transaction->save();
                    $transaction = new Transactions();
                    $transaction->token = "LAP-$id".session('id_user').rand(000000,999999);
                    $transaction->status = "pending";
                    $transaction->booklists_id = $id;
                    $transaction->total = $total;
                    $item_details = array([
                        'id' => $transaction->token,
                        'price' => round($total),
                        'quantity' => 1,
                        'name' => "testing Lapangan"
                    ]);
                    $transaction_details = array(
                        'order_id' => $transaction->token,
                        'gross_amount' => round($total)
                    );
                    $customer_details = array(
                        'first_name' => "asdasdasd",
                        'email' => "lapangankrisna@gmail.com",
                        'phone' => $user->number,
                    );
                    $credit_card['secure'] = true;
                    $transaction_data = array(
                        'transaction_details'=> $transaction_details,
                        'item_details' => $item_details,
                        'customer_details' => $customer_details,
                        'credit_card' => $credit_card,
                        'whitelist_bins' => [],
                        // 'expiry'             => $custom_expiry
                    );
                    $midtransTrans = Snap::createTransaction($transaction_data);
                    $transaction->midtrans_token = $midtransTrans->token;
                    $transaction->save();
                }
            // }else{
            //     if($beda){
            //         $transaction->status = 'gagal';
            //         $transaction->save();
            //         $transaction = new Transactions();
            //         $transaction->token = "LAP-$id".session('id_user').rand(000000,999999);
            //         $transaction->status = "pending";
            //         $transaction->booklists_id = $id;
            //         $transaction->total = $total;
            //         $params = [
            //             'transaction_details'=>[
            //                 'order_id'=>$transaction->token,
            //                 'gross_amount'=>$total
            //             ],
            //             'customer_details'=>[
            //                 'first_name'=>$user->name,
            //                 'phone'=>$user->number,
            //             ]
            //         ];
            //         $midtransTrans = Snap::createTransaction($params);
            //         $transaction->midtrans_token = $midtransTrans->token;
            //         $transaction->save();
            //     }
            }
        }
        $booklist->save();
        $response['status'] = true;
        $response['token'] = $transaction->midtrans_token;
        return response()->json($response);
    }

    public function saving_review(Request $request)
    {
        if(!session()->has('id_user')) return redirect()->back()->with("failed-message","Rating kamu gagal kami simpan!");
        $user_id = session('id_user');
        $booklist = Booklists::where('id',$request->id)->get()->first();
        if($booklist->status != 'complete') return redirect()->back()->with("failed-message","Rating kamu gagal kami simpan!");
        $booklist->rating = $request->rating;
        $booklist->review = $request->review;
        if(!$booklist->save()) return redirect()->back()->with("failed-message","Rating kamu gagal kami simpan!");
        return redirect()->back()->with("success-message","Rating kamu berhasil kami simpan!");
    }

    // sisi merchant
    public function requesting_balance(Request $request)
    {
        $jumlah = $request->post('jumlah');
        $merchant = Merchant::where('user_id',session('id_user'))->first();
        $history = History_Balance::where('merchant_id',$merchant->id)->get()->all();
        $saldo = 0;
        if($history){
            foreach($history as $item){
                if($item->type == 'masuk'){
                    $saldo += $item->total;
                }
                if($item->type == 'keluar' || $item->type == 'pending'){
                    $saldo -= $item->total;
                }
            }
        }
        if($saldo<$jumlah) return redirect()->back()->with('failed-message','Saldo tidak mencukupi');
        if(50000>$jumlah) return redirect()->back()->with('failed-message','Penarikan Saldo harus lebih dari Rp.50.000');
        $history = new History_Balance;
        $history->merchant_id = $merchant->id;
        $history->total = $jumlah;
        $history->type = 'pending';
        $history->catatan = 'Tarik Saldo';
        $history->save();
        return redirect()->back()->with('success-message','Berhasil melakukan penarikan saldo, mohon tunggu beberapa saat');
    }
    public function request_balance(Request $request)
    {
        $merchant = Merchant::where('user_id',session('id_user'))->first();
        $history = History_Balance::where('merchant_id',$merchant->id)->orderBy('id','desc')->get();
        $saldo = 0;
        if($history){
            foreach($history as $item){
                if($item->type == 'masuk'){
                    $saldo += $item->total;
                }
                if($item->type == 'keluar' || $item->type == 'pending'){
                    $saldo -= $item->total;
                }
            }
        }
        $data = [
            'history'=>$history,
            'merchant'=>$merchant,
            'saldo'=>$saldo
        ];
        return view('user.laporan-saldo',$data);
    }

    // sisi admin
    public function request_saldo()
    {
        $request = History_Balance::where('type','pending')->get()->all();
        $data = [
            'request'=>$request
        ];
        return view('admin.request-saldo',$data);
    }
    public function completing_transaction(Request $request)
    {
        $id = $request->post('id');
        // $booklist = Booklists::where('id',$id)->first();
        $booklist = Booklists::whereHas('transaction',function($query){
            return $query->where('status', 'berhasil');
        })->where('id',$id)->first();
        $booklist->status = 'complete';
        $booklist->save();
        $lapangan = $booklist->lapangan;
        $merchant = $lapangan->merchant;
        $history = new History_Balance();
        $history->merchant_id = $merchant->id;
        $history->type = 'masuk';
        $history->total = $booklist->transaction[0]->total;
        $history->catatan = "Booking Lapangan";
        $history->save();
        return redirect()->back();
    }
}
