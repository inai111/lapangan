<?php

namespace App\Http\Controllers;

use App\Models\Booking_date;
use App\Models\Booklists;
use App\Models\Fasilitas;
use App\Models\Fasilitas_merchant;
use App\Models\Gallery;
use App\Models\Jenis_olahraga;
use App\Models\Lapangan;
use App\Models\Merchant;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Home extends Controller
{
    public function index(Request $request)
    {
        $arr_cookie = [];
        $lapangan_where = []; // lapangan dari pencarian

        # ambil lapangan semua, kalau ada rekomendasi, maka
        # ambil semua lapangan yang selain dari rekomendasi,
        $lapangan = Lapangan::whereHas('merchant',function($query){
            return $query->where('status_merchant', 'active');
        });
        
        $rating = $this->get_rating();
        
        $lapangan_where = Lapangan::whereHas('merchant',function($query){
            return $query->where('status_merchant', 'active');
        });

        # ambil lapangan dari jalur riwayat pencarian
        if($request->cookie('pencarianHistory')){
            $arr_cookie = (array)json_decode($request->cookie('pencarianHistory'));
            if(!empty($arr_cookie)){
                arsort($arr_cookie);
                $i = 1;
                $orderby = "CASE ";
                foreach($arr_cookie as $cookie=>$value){
                    $lapangan_where = $lapangan_where->orwhere(function($query) use($cookie){
                        $query->where('nama','like',"%$cookie%")
                        ->orwhereHas('merchant',function($query1) use($cookie){
                            return $query1->where('nama','like',"%$cookie%")
                            ->orwhere('alamat','like',"%$cookie%");
                        })
                        ->orwhereHas('jenis',function($query1) use($cookie){
                            return $query1->where('nama','like',"%$cookie%");
                        });
                    });
                    $orderby.="WHEN lapangan.nama = '$cookie' then $i ";
                    // $orderby.="WHEN merchant.nama = '$cookie' then $i ";
                    // $orderby.="WHEN jenis_olahraga.nama = '$cookie' then $i ";
                    $i++;
                }
                $orderby.="END desc";
                $lapangan_where=$lapangan_where->orderbyRaw($orderby);
                // $lapangan_where=$lapangan_where->orderby('id','desc')->limit(5)->get();
                $lapangan_where=$lapangan_where;
            }
        }

        # ambil lapangan dari jalur rekomendasi filtering item based
        $rekomendasi = [];
        $lapangan_rekomendasi = [];
        $lapangan_rekomendasi1 = [];
        if(session('id_user')){
            $rekomendasi = $this->get_recomendation();
            if($rekomendasi){
                $lapangan_rekomendasi = Lapangan::whereHas('merchant',function($query){
                    return $query->where('status_merchant', 'active');
                });
                $lapangan_rekomendasi = $lapangan_rekomendasi->whereIn('id',array_keys($rekomendasi));
                $lapangan_rekomendasi1 = [];
                foreach($lapangan_rekomendasi->get()->all() as $lap){
                    $lapangan_rekomendasi1[$lap->id] = $lap;
                }

                $lapangan->whereNotIn('id',array_keys($rekomendasi));
            }
        }

        # ambil data merchant
        $merchants = Merchant::where('status_merchant', 'active')->get();
        foreach($merchants as $key=>$item){
            $merchants[$key]->rating = $this->get_rating($item->id);
        }
        $data = [
            'lapangan' => $lapangan->get(),
            'lapangan_where' => $lapangan_where->limit(5)->get(),
            'rekomendasi' => $rekomendasi,
            'lapangan_rekomendasi' => $lapangan_rekomendasi1,
            'rating_almanak' => $rating,
            'merchants' => $merchants,
        ];
        return view('home',$data);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username'=> 'required|regex:/^\S*$/u',
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
            $userdata = User::where('username',$data['username'])->first();
            $request->session()->regenerate();
            $request->session()->put('id_user',$userdata['id']);
            $request->session()->put('role',$userdata['role']);
            $request->session()->put('username',$userdata['username']);
            $response['message'] = "welcome back {$request->username}, please wait.";
            $response['status'] = true;
            if($userdata['role'] == 'admin') $response['href'] = "/dashboard";
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
            $userCreate->nama = $name;
            $userCreate->username = $username;
            $userCreate->nomor = $number;
            $userCreate->password = Hash::make($password);
            $userCreate->save();
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
        $pencarian_arr_percent = explode(' ',$search_arr[0]);
        $arr_cookie = [];

        if($request->cookie('pencarianHistory')){
            $arr_cookie = (array)json_decode($request->cookie('pencarianHistory'));
        }
        foreach($pencarian_arr_percent as $value){
            if(isset($arr_cookie[$value])){
                // $arr_cookie->$value+=1;    
                $arr_cookie[$value]+=1;    
            }else{
                if(strlen($value) > 4) {
                    $arr_cookie[$value]=1;
                }
            }
        }
        $cookie = json_encode($arr_cookie);
        switch($query_to){
            case "merchant":
                $merchant = Merchant::select(DB::raw('*,"merchant" as type'))->orderBy('id',$sort_by)->where('nama','like',"%$search_arr[0]%")->where('status_merchant','active');
                $merchant = $merchant->take(6)->get();
                $result = $merchant;
                break;
            case "lapangan":
                $lapangan = Lapangan::select(DB::raw('*,"lapangan" as type'))->orderBy('id',$sort_by)->where('nama','like',"%$search_arr[0]%");
                $lapangan = $lapangan->take(6)->get();
                foreach($lapangan as $key => $item){
                    $lapangan[$key]['merchant'] = $item->merchant;
                    $lapangan[$key]['jenis'] = $item->jenis;
                }
                $result = $lapangan;
                break;
            default:
                    $merchant = Merchant::select(DB::raw('*,"merchant" as type'))->orderBy('id',$sort_by)->where('nama','like',"%$search_arr[0]%")->where('status_merchant','active');
                    $merchant = $merchant->take(3)->get()->toArray();
                    $lapangan = Lapangan::select(DB::raw('*,"lapangan" as type'))->orderBy('id',$sort_by)->where('nama','like',"%$search_arr[0]%");
                    $lapangan = $lapangan->take(3)->get();
                    foreach($lapangan as $key => $item){
                        $lapangan[$key]['merchant'] = $item->merchant;
                        $lapangan[$key]['jenis'] = $item->jenis;
                    }
                    $result = array_merge($merchant,$lapangan->toArray());
                break;
        }
        $response = [
            'result'=>$result,
            'cookie'=>$request->cookie('pencarianHistory')
        ];
        return response()->json($response)->cookie('pencarianHistory',$cookie,1440);
    }

    #lapangan/num
    public function detail_lapangan($id)
    {
        $lapangan = Lapangan::where('id',$id)->first();
        $lapangan->harga = number_format($lapangan->harga,0,',','.');
        $merchant = $lapangan->merchant;
        $booklist = $lapangan->booklist;
        $booklist = Booklists::where('lapangan_id',$id)->where('rating','!=',null)->get();
        $review_rating = [];
        $rating = 0;
        if($booklist){
            $jumlah = 0;
            foreach($booklist as $key=>$book){
                if($book->rating && $book->user){
                    $review_rating [$key] = $book;
                    $rating += $book->rating;
                    $jumlah ++;
                }
            }
            if($rating && $jumlah) $rating = number_format(round($rating/$jumlah),0);
        }
        $nama_lapangan = str_replace(' ','_',$lapangan->nama);

        $urlCoverLapangan = "/assets/img/{$nama_lapangan}/cover/{$lapangan->cover}";
        if(!file_exists($urlCoverLapangan)){
            $urlCoverLapangan = "/assets/img/lapangan/cover/{$lapangan->cover}";
        }
        $objMsg = [
            'profilePic'=>$merchant->user->foto,
            'merchantName'=>$merchant->nama,
            'id_merchant'=>$merchant->id,
            'lapaganId'=>$lapangan->id,
            'userId'=>$merchant->user_id,
            'namaLapangan'=>ucwords(strtolower($lapangan->nama)),
            'hargaLapangan'=>"Rp. {$lapangan->harga} /Jam",
            'urlCover'=>$urlCoverLapangan,
        ];
        $data = [
            'lapangan'=>$lapangan,
            'nama_lapangan_dir'=>str_replace(' ','_',$lapangan['nama']),
            'urlCover'=>$urlCoverLapangan,
            'galeries'=>$lapangan->galleries,
            'merchant'=>$merchant,
            'rating'=>$rating,
            'jumlah'=>$jumlah,
            'booklist'=>$booklist,
            'booklist_review'=>$review_rating,
            'objMsg'=>base64_encode(json_encode($objMsg))
        ];
        return view("detail-lapangan",$data);
    }
    public function get_jadwal_lapangan($id,Request $request)
    {
        $response = [
            'status'=>false,
            "message"=>"Tidak ada Jadwal yang dapat di ambil"
        ];
        $tanggal = $request->get('tanggal');
        if(empty($tanggal)) return response()->json($response);
        $thisBook = Booklists::where('id',$id)->first();
        // $lapangan = Lapangan::where('id',$thisBook->lapangan_id)->first();
        $lapangan = $thisBook->lapangan;
        if(empty($lapangan)) return response()->json($response);
        $lapanganBook = Booklists::whereHas('booking_date', function($query) use ($tanggal){
            return $query->where('tanggal','>=', $tanggal);
        })->where('lapangan_id', $lapangan->id)->where('status','!=','cancel')->get();
        // $lapanganBook = Booklists::where('lapangan_id',$id)->where('status','!=','cancel')->get();
        $bookingan = [];
        foreach($lapanganBook as $item){
            // $itemBook = Booking_date::where('booklists_id',$item->id)->where('tanggal',$tanggal)->get();
            $itemBook = $item->booking_date;
            if($itemBook){
                foreach($itemBook as $book){
                    $bookingan []=$book;
                }
            }
        }
        
        // $bookingan = Booking_date::where('lapangan_id',$id)->where('tanggal',$tanggal)->get()->all();
        // $merchant = Merchant::where('id',$lapangan->merchant_id)->first();
        $merchant = $lapangan->merchant->first();
        if(empty($merchant)) return response()->json($response);
        $open = date("H",strtotime($merchant->buka));
        $close = date("H",strtotime($merchant->tutup));
        $available_jam = [];
        $i =0;
        // dd($open,$close);
        for($open;$open<$close;$open++){

            $available_jam [$i] = [
                'tanggal'=>$tanggal,
                'jam'=>"$open:00",
                'harga'=>$lapangan->harga,
                'book'=>false
            ];
            if($bookingan){
                foreach($bookingan as $book){
                    if($open == date("H",strtotime($book->jam))) $available_jam[$i]['book'] = true;
                }
            }
            // if(($open <= date('H') && date('Y-m-d') == $tanggal)) $available_jam[$i]['book'] = true;
            if(($open <= date('H') && date('Y-m-d') == $tanggal)) $available_jam[$i]['book'] = true;
            $i++;
        }
        // $booklists = Booklists::where('lapangan_id','=',$thisBook->lapangan_id)
        // ->where('jam_akhir',">=",date("Y-m-d H:0:0"))->get()->all();
        // $init_jam = strtotime($merchant->open);
        // $jam = $init_jam;
        // $open_jam = $init_jam;
        // $close_jam = strtotime($merchant->close);
        // $available_jam = [];
        // $i = 0;
        // $end_loop = strtotime("+3day".$merchant->open);
        // do{
        //     $i ++;
        //     if($jam<$close_jam && $jam>=$open_jam){
        //         if($booklists){
        //             foreach($booklists as $booklist){
        //                 // $available_jam[]=date("Y-m-d H:00:00",$jam);
        //                 $book_awal = strtotime($booklist->jam_awal);
        //                 $book_akhir = strtotime($booklist->jam_akhir);
        //                 $thisBookEnd = strtotime("+$lengthThisBook hour".date("Y-m-d H:00:00",$jam));
        //                 if($book_awal !== $jam && $thisBookEnd < $close_jam && $jam !== $close_jam){
        //                     $available_jam[date("Y-m-d",$jam)][]= date('H:00:00',$jam)." - ".date('H:00:00',$thisBookEnd) ;
        //                     $jam = strtotime("+1Hour".date("Y-m-d H:00:00",$jam));
        //                 }else if($book_awal == $jam){
        //                     $lengthBook = $booklist->length;
        //                     $jam = strtotime("+$lengthBook Hour".date("Y-m-d H:00:00",$jam));
        //                 }else{
        //                     $jam = strtotime("+1Hour".date("Y-m-d H:00:00",$jam));
        //                 }
        //             }
        //         }else{
        //             if($jam !== $close_jam){
        //                 $thisBookEnd = strtotime("+$lengthThisBook hour".date("Y-m-d H:00:00",$jam));
        //                 $available_jam[date("Y-m-d",$jam)][]= date('H:00:00',$jam)." - ".date('H:00:00',$thisBookEnd) ;
        //                 $jam = strtotime("+1Hour".date("Y-m-d H:00:00",$jam));
        //             }
        //         }
        //     }else {
        //         $open_jam = strtotime("+1day".date("Y-m-d H:00:00",$open_jam));
        //         $jam = $open_jam;
        //         $close_jam = strtotime("+1day".date("Y-m-d H:00:00",$close_jam));
        //     }

        // }while($jam < $end_loop);
        $response['status']=true;
        $response['data']=$available_jam;
        $response['message']='';
        return response()->json($response);
    }

    public function detail_merchant($id)
    {
        $merchant = Merchant::where('id',$id)->where('status_merchant','active')->first();
        if(empty($merchant)) return abort(404);
        $user = $merchant->user;
        $lapangan = $merchant->lapangan;
        foreach($lapangan as $key=>$lap){
            $lapangan[$key]['lapangan_cover']=str_replace(' ','_',$lap['nama']);
        }
        // $fasilitas_merchant = 
        $data = [
            'merchant'=>$merchant,
            'rating_data'=>$this->get_rating($id),
            'user'=>$user,
            'fasilitas_merchant' => $merchant->fasilitas_merchant,
            'lapangan'=>$lapangan
        ];
        return view("beranda-merchant",$data);
    }

    public function sending_message(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'message'=> 'required',
            'target_id'=> 'required',
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
        $message = new Message();
        $message->from_id = session('id_user');
        $message->to_id = $request->target_id;
        $message->body = $request->message;
        $message->read = 0;
        $message->lapangan_id = $request->ref_id;
        $response['status'] = $message->save();
        return response()->json($response);
    }

    public function get_message(Request $request)
    {
        if(!session()->has('id_user')) return redirect('/');
        $target = $request->get('target_id');
        if(!$target) return response()->json(['message'=>[]]);
        $user_id = session('id_user');
        // $messages = Message::where("from_id",$user_id)->orwhere('to_id',$user_id)->orwhere('from_id',$target)->orwhere('to_id',$target)->get()->all();
        $messages = Message::where(function($query) use($target,$user_id){
            $query->where('from_id',$target);
            $query->where('to_id',$user_id);
        })->orwhere(function($query) use($target,$user_id){
            $query->where('from_id',$user_id);
            $query->where('to_id',$target);
        })->get()->all();
        foreach($messages as $key => $msg)
        {
            $messages[$key]['tanggal'] = date('d-M-Y',strtotime($msg['created_at']));
            $messages[$key]['jam'] = date('H:i',strtotime($msg['created_at']));
            if($msg['lapangan_id']) {
                $lapangan = $msg->lapangan;
                $nama_lapangan = str_replace(' ','_',$lapangan->nama);
                // $lapangan = Lapangan::select('nama','harga','cover')->where('id',$msg['ref_id'])->get()->first();
                $messages[$key]['lapangan'] = $lapangan;
                $messages[$key]['lapangan']['cover'] = asset("assets/img/{$nama_lapangan}/{$lapangan->cover}");//path cover lapangan message
                $messages[$key]['lapangan']['harga'] = number_format($lapangan->harga,0,',','.');//path cover lapangan message
                $messages[$key]['lapangan']['nama'] = ucwords(strtolower($lapangan->nama));//path cover lapangan message
            }
        }
        // update read
        $update_batch = Message::where('to_id',$user_id)->where('from_id',$target)->where('read',0)->get();
        $unread = !empty($update_batch->all())?true:false;
        foreach($update_batch as $update)
        {
            $update->read = 1;
            // $update->save();
        }
        $result = [
            'messages'=>$messages,
            'last'=>end($messages),
            'unread'=>$unread,
        ];
        // dd(($messages));
        return response()->json($result);
    }

    public function get_unread_message()
    {
        $response = [
            'status'=> false
        ];
        if(!session()->has('id_user')) return response()->json($response);
        $id = session('id_user');
        $unread_message = Message::where('to_id',$id)->where('read',0)->get()->all();
        $messages = Message::where('to_id',$id)->orwhere('from_id',$id)->orderby('id','desc')->get();
        $container_msg = [];
        if(!empty($messages->first())){
            foreach($messages as $key => $msg)
            {
                $msg['tanggal'] = date("d-F-Y H:i:s",strtotime($msg['created_at']));
                if($msg['from_id'] != $id && empty($container_msg[$msg['from_id']])){
                    $msg['user'] = $msg->pengirim;
                    $msg['profilPic'] = "/assets/img/profilpic/{$msg->pengirim->foto}";
                    $msg['role'] = 'menerima';
                    $msg['user']['profilPic'] = $msg['profilPic'];
                    $msg['obj'] = base64_encode(json_encode($msg['user']));
                    $container_msg[$msg['from_id']] = $msg;
                }elseif($msg['to_id'] != $id && empty($container_msg[$msg['to_id']])){
                    $msg['user'] = User::where('id',$msg->to_id)->first();
                    $msg['profilPic'] = "/assets/img/profilpic/{$msg['user']['foto']}";
                    $msg['role'] = 'mengirim';
                    $msg['user']['profilPic'] = $msg['profilPic'];
                    $msg['obj'] = base64_encode(json_encode($msg['user']));
                    $container_msg[$msg['to_id']] = $msg;
                }
            }
        }
        // foreach($messages as $key => $val){
        //     $user = $val->pengirim;
        //     $user->nama = ucwords(strtolower($user->nama));
        //     $user->foto = "/assets/img/profilpic/".$user->foto;
        //     $messages[$key]['user'] = $user;
        //     $messages[$key]['tanggal'] = date("d-F-Y H:i:s",strtotime($val['created_at']));
        // }
        // dd($messages);
        $response['status']=true;
        $response['unreadMessages']=$unread_message;
        $response['messages']=$container_msg;
        return response()->json($response);
    }


    public function similarityDistance($preferences=[], $person1, $person2)
    {
        $similar = array();
        $sum = 0;
        // [lapangan_1]=1
        foreach($preferences[$person1] as $key=>$value)
        {
            if(array_key_exists($key, $preferences[$person2]))
            $similar[$key] = 1;
        }
        // dari sini memilih referensi item nya, kalau
        // si user tidak pernah memesan item A maka tidak di
        // gunakan rekomendasi darinya
        if(count($similar) == 0)
            return 0;
        
        foreach($preferences[$person1] as $key=>$value)
        {
            if(array_key_exists($key, $preferences[$person2])){
                $sum = $sum + pow(($value - $preferences[$person2][$key]), 2);
            }
        }
        
        return  1/(1 + sqrt($sum)); 
    }
    // function untuk item colaborative filtering 
    // function ini untuk mencari user dari semua user yang mirip dengan user A
    // public function similarityBooklist($booklist_users=[], $booklist_user_lains = [])
    // {
    //     $similar = array();
    //     $sum = 0;

    //     foreach($booklist_users as $key=>$val)
    //     {
    //         if(array_key_exists($key, $booklist_user_lains)) $similar[$key] = 1;
    //     }
    //     if(count($similar) == 0) return 0;
        
    //     foreach($booklist_users as $key=>$val)
    //     {
    //         if(array_key_exists($key, $booklist_user_lains)) $sum = $sum + pow($val - $booklist_user_lains[$key], 2);
    //     }
    //     return  1/(1 + sqrt($sum));     
    // }
    

    public function get_recomendation()
    {
        $total = array();
        $simSums = array();
        $ranks = array();
        $sim = 0;

        // data lapangan yang sudah di pesan dan di rating oleh semua user
        // isinya
        /*
        [
            user_id1 = [id_lapangan1, id_lapangan2, ...], 
            user_id2 = [id_lapangan1, id_lapangan2, ...], 
        ]
         */
        $cek_booklist = Booklists::where('user_id', session()->get('id_user'))->where('rating','!=','')->get()->all();
        if(empty($cek_booklist)) return false;
        /**
         * mendapatkan jenis olahraga id yang user pernah berikan rating
         */
        $jenis_lapangan = [];
        foreach ($cek_booklist as $item) {
            if(!in_array($item,$jenis_lapangan)) $jenis_lapangan[] = $item->lapangan['jenis_olahraga_id'];
        }

        $preferences_db = Booklists::select('user_id','lapangan_id', DB::raw("sum(rating)/count(lapangan_id) as rating"))->where('rating','!=','')->groupby('lapangan_id','user_id')->whereHas('lapangan',function($query)use($jenis_lapangan){
            return $query->whereIn('jenis_olahraga_id', $jenis_lapangan);
        })->get()->all();

        /**
         * untuk ngecek apakah references nya jenis lapangan id nya sesuai yang pernah
         * dirating oleh user
         */
        // //---------------
        // $lapangan = [];
        // foreach ($preferences_db as $item){
        //     $lapangan [] = $item->lapangan['jenis_olahraga_id'];
        // }
        // dd($lapangan);
        // //---------------

        $preferences = [];
        /*
            person digunakan untuk menyimpan 1 array yang berisi lapangan yang pernah
            di rating untuk di jadikan refersnsi item based nya
        */
        $person = session()->get('id_user');
        if(count($preferences_db) != 0){
            foreach( $preferences_db as $item){
                $preferences[$item['user_id']][$item['lapangan_id']] = $item['rating'];
            }
        }
        // [user_b]
        // [user_a]
        // [lapanga_1] key 
        // [3] value 
        // [lapanga_1]=5
        // [user_c][lapanga_1]=3
        // [user_d][lapanga_1]=3
        // [user_a][lapanga_2]=3
        // [user_a][lapanga_3]=3
        foreach($preferences as $otherPerson=>$values)
        {
            if($otherPerson != $person)
            {
                $sim = $this->similarityDistance($preferences, $person, $otherPerson);
            }
            
            if($sim > 0)
            {
                foreach($preferences[$otherPerson] as $key=>$value)
                {
                    /**
                     * isi dari total per foreach
                     * [
                     *  lapangan_id = rating
                     *  lapangan_1 = 3
                     *  lapangan_2 = 3
                     *  lapangan_3 = 3
                     * ]
                     * isi dari simSums per foreach
                     * [
                     *  lapangan_id = similarityDistance
                     *  lapangan_1=1
                     *  lapangan_2=1
                     *  lapangan_3=1
                     * ]
                     */
                    if(!array_key_exists($key, $preferences[$person]))
                    {
                        if(!array_key_exists($key, $total)) {
                            // cuman inisial index agar tidak error saat di panggil
                            $total[$key] = 0; 
                        }
                        $total[$key] += $preferences[$otherPerson][$key] * $sim;
                        
                        if(!array_key_exists($key, $simSums)) {
                            // cuman inisial index agar tidak error saat di panggil
                            $simSums[$key] = 0;
                        }
                        $simSums[$key] += $sim;
                    }
                }
                
            }
        }

        foreach($total as $key=>$value)
        {
            // $ranks[$key] = $value / $simSums[$key];
            $ranks[$key] = number_format((($value / $simSums[$key]) /5)*100,2);   
        }
        arsort($ranks);
        
        return $ranks;
    }

    // public function get_recomendation()
    // {
    //     $total = [];
    //     $simSums = [];
    //     $ranks = [];
    //     $sim = 0;
    //     // referensi yang rating nya != null dan status telah complete
    //     $booklist = Booklists::select('user_id')->where('rating','!=',null)->where('user_id','!=',session('id_user'))->groupby('user_id')->get();
    //     foreach($booklist->all() as $values)
    //     {
    //         $booklist_users = [];
    //         $booklist_user = Booklists::select('lapangan_id',DB::raw("sum(rating)/count(lapangan_id) as rating"))->where('user_id',session('id_user'))->groupby('lapangan_id')->get();
    //         foreach($booklist_user as $key=>$val)
    //         {
    //             $booklist_users [$val->lapangan_id] = $val->rating;
    //         }
    //         // booklist milik user lain
    //         $booklist_user_lains = [];
    //         $booklist_user_lain = Booklists::select('lapangan_id',DB::raw("sum(rating)/count(lapangan_id) as rating"))->where('user_id',$values->user_id)->groupby('lapangan_id')->get();
    //         foreach($booklist_user_lain->all() as $key=>$val)
    //         {
    //             $booklist_user_lains [$val->lapangan_id] = $val->rating;
    //         }
    //         $sim = $this->similarityBooklist($booklist_users, $booklist_user_lains);
    //         // kurang bagian bawah
    //         if($sim > 0)
    //         {
    //             foreach($booklist_user_lains as $key=>$value)
    //             {
    //                 if(!array_key_exists($key, $booklist_users))
    //                 {
    //                     if(!array_key_exists($key, $total)) {
    //                         $total[$key] = 0;
    //                     }
    //                     $total[$key] += $booklist_user_lains[$key] * $sim;
                        
    //                     if(!array_key_exists($key, $simSums)) {
    //                         $simSums[$key] = 0;
    //                     }
    //                     $simSums[$key] += $sim;
    //                 }
    //             }
                
    //         }
    //     }

    //     foreach($total as $key=>$value)
    //     {
    //         $ranks[$key] = number_format((($value / $simSums[$key])/5)*100,2);
    //     }
    //     arsort($ranks);
    //     // array_multisort($ranks, SORT_DESC);
    //     return $ranks;
        
    // }

    public function get_rating($id=null){
        $rate = [];
        // $lapangan=Lapangan::
        $lapangan = Lapangan::whereHas('merchant',function($query) use ($id) {
            if(!empty($id)) $query->where('merchant_id', $id);
            $query->where('status_merchant', 'active');
        })->whereHas('booklist',function($query){
            $query->whereNotNull('rating');
        })
        ->with(['booklist' => function ($query) {
            $query->whereNotNull('rating');
        }])->get();
        $rating_merchant = 0;
        $jumlah_booklist = 0;
        foreach($lapangan as $item){
            if(!empty($item->booklist) && count($item->booklist)>0){
                $rate[$item->id]['jumlah_booklist'] = count($item->booklist);
                $jumlah_booklist += count($item->booklist);
                $rating = 0;
                foreach($item->booklist as $book){
                    $rating+=$book->rating;
                    $rating_merchant+=$book->rating;
                }
                $rate[$item->id]['rating'] = number_format(round($rating/count($item->booklist)),0);
            }
        }
        if(!empty($id) && $jumlah_booklist && $rating_merchant){
            $rate ['jumlah_booklist_merchant'] = $jumlah_booklist;
            $rate ['rating_merchant'] = number_format(round($rating_merchant/$jumlah_booklist),0);
            // $rate = [
            //     'jumlah_booklist' => $jumlah_booklist,
            //     'rating_merchant' => number_format(round($rating_merchant/$jumlah_booklist),0)
            // ];
        }
        return $rate;
    }

    public function search_all(Request $request){
        $type = $request->get('type');
        $search = $request->get('search');
        $jenis = $request->get('jenis');
        $query = [];
        switch($type){
            case'merchant':
                $query = Merchant::where('status_merchant', '=', 'active');
                if(!empty($search)){
                    #cari di merchant
                    $query->where(function($qu)use($search){
                        return $qu->where('nama', 'like', '%'. $search. '%')
                        ->orWhere('alamat', 'like', '%'. $search. '%')
                        #cari di user
                        ->orWhereHas('user',function($que) use($search){
                            return $que->orWhere('username', 'like', '%'. $search. '%')
                            ->orWhere('nama', 'like', '%'. $search. '%');
                        });
                    });
                }
                // $query = $query->limit(10);
                $query = $query->get()->all();
                break;
            case'lapangan':
                $query = Lapangan::whereHas('merchant',function($que){
                    return $que->where('status_merchant', '=', 'active');
                });
                if(!empty($search)){
                    #cari di lapangan
                    $query->where(function($qu)use($search,$jenis){
                        return $qu->where('nama', 'like', '%'. $search. '%')
                        #cari di merchant
                        ->orWhereHas('merchant', function($que)use($search){
                            return $que->where('nama', 'like', '%'. $search . '%')
                            ->orWhere('alamat', 'like', '%'. $search . '%')
                            #cari di user
                            ->orWhereHas('user', function($quer)use($search){
                                return $quer->where('username', 'like', '%'. $search . '%')
                                ->orWhere('nama', 'like', '%'. $search . '%');
                            });
                        })
                        #cari di jenis_lapangan
                        ->orWhereHas('jenis',function($que) use($jenis, $search){
                            return $que->where('nama', '=',$jenis)
                            ->orWhere('nama', 'like',"%{$search}%");
                        });
                    });
                }
                // $query = $query->limit(10);
                $query = $query->get()->all();
                // $query = $query->paginate(10);
                break;
            default:
            $query_merchant = Merchant::where('status_merchant', '=', 'active');
            $query_lapangan = Lapangan::whereHas('merchant',function($que){
                return $que->where('status_merchant', '=', 'active');
            });

            if(!empty($search)){
                #cari di merchant
                $query_merchant->where(function($qu)use($search){
                    return $qu->where('nama', 'like', '%'. $search. '%')
                    ->orWhere('alamat', 'like', '%'. $search. '%')
                    #cari di user
                    ->orWhereHas('user',function($que) use($search){
                        return $que->orWhere('username', 'like', '%'. $search. '%')
                        ->orWhere('nama', 'like', '%'. $search. '%');
                    });
                });
                #cari di lapangan
                $query_lapangan->where(function($qu)use($search,$jenis){
                    return $qu->where('nama', 'like', '%'. $search. '%')
                    #cari di merchant
                    ->orWhereHas('merchant', function($que)use($search){
                        return $que->where('nama', 'like', '%'. $search . '%')
                        ->orWhere('alamat', 'like', '%'. $search . '%')
                        #cari di user
                        ->orWhereHas('user', function($quer)use($search){
                            return $quer->where('username', 'like', '%'. $search . '%')
                            ->orWhere('nama', 'like', '%'. $search . '%');
                        });
                    })
                    #cari di jenis_lapangan
                    ->orWhereHas('jenis',function($que) use($jenis, $search){
                        return $que->where('nama', '=',$jenis)
                        ->orWhere('nama', 'like',"%{$search}%");
                    });
                });
            }
            $query = array_merge($query_merchant->get()->all(),$query_lapangan->get()->all());
            // $query = array_merge($query_lapangan->get()->all(),$query_merchant->get()->all());
            // shuffle($query);
            // $per_page = 10;
            // $query_lapangan_total = $query_lapangan->count();;
            // dd($query_lapangan_total);
            // $query_merchant = $query_merchant->paginate($per_page - count($query_lapangan));
            // $query = $query_lapangan->merge($query_merchant);

            break;
        }

        # rating per merchant
        $rating_merchant = [];
        $rating_lapangan = $this->get_rating();
        $fasilitas_merchant = [];
        foreach ($query as $item){
            if(empty($item->merchant_id)){
                $rating_mer = $this->get_rating($item->id);
                if($rating_mer) $rating_merchant[$item->id] = $rating_mer;
                if(!empty($item->fasilitas_merchant)){
                    $fasilitas_merchant[$item->id] = '';
                    foreach($item->fasilitas_merchant as $merch){
                        if($merch->fasilitas->fasilitas){
                            $fasilitas_merchant[$item->id] .= $merch->fasilitas->fasilitas.', ';
                            $fasilitas_merchant[$item->id] .= $merch->fasilitas->fasilitas.', ';
                            $fasilitas_merchant[$item->id] .= $merch->fasilitas->fasilitas.', ';
                        }
                    }
                }
            }
        }
        $data = [
            'queries' => $query,
            'jenis'=>Jenis_olahraga::all(),
            'rating_lapangan' => $rating_lapangan,
            'rating_merchant' => $rating_merchant,
            'fasilitas_merchant' => $fasilitas_merchant,
        ];
        return view('search-all',$data);
    }
}
