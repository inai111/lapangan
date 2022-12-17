<?php

namespace App\Http\Controllers;

use App\Models\Booking_date;
use App\Models\Booklists;
use App\Models\Gallery;
use App\Models\Lapangan;
use App\Models\Merchant;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Home extends Controller
{
    public function index()
    {
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
        $rating = 0;
        if($booklist){
            $jumlah = 0;
            foreach($booklist as $book){
                if($book->rating){
                    $rating += $book->rating;
                    $jumlah ++;
                }
            }
            if($rating && $jumlah) $rating = $rating/$jumlah;
        }
        $objMsg = [
            'profilePic'=>$merchant->user->photo,
            'merchantName'=>$merchant->name_merchant,
            'id_merchant'=>$merchant->id,
            'lapaganId'=>$lapangan->id,
            'userId'=>$merchant->user_id,
            'namaLapangan'=>ucwords(strtolower($lapangan->nama)),
            'hargaLapangan'=>"Rp. {$lapangan->harga} /Jam",
            'urlCover'=>"/assets/img/profilpic/default.png",
        ];
        $data = [
            'lapangan'=>$lapangan,
            'galeries'=>$lapangan->galleries,
            'merchant'=>$merchant,
            'rating'=>$rating,
            'jumlah'=>$jumlah,
            'booklist'=>$booklist,
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
        $data = [
            'merchant'=>$merchant,
            'user'=>$user,
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
                // $lapangan = Lapangan::select('nama','harga','cover')->where('id',$msg['ref_id'])->get()->first();
                $messages[$key]['lapangan'] = $lapangan;
                $messages[$key]['lapangan']['cover'] = asset("assets/img/profilpic/{$lapangan->cover}");//path cover lapangan message
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
        $messages = Message::where('to_id',$id)->orderby('id','desc')->get()->unique('from_id');
        // $messages = Message::where('to_id',$id)->orderby('id','desc')->get();
        foreach($messages as $key => $val){
            $user = $val->pengirim;
            $user->nama = ucwords(strtolower($user->nama));
            $user->foto = "/assets/img/profilpic/".$user->foto;
            $messages[$key]['user'] = $user;
            $messages[$key]['tanggal'] = date("d-F-Y H:i:s",strtotime($val['created_at']));
        }
        $response['status']=true;
        $response['unreadMessages']=$unread_message;
        $response['messages']=$messages;
        return response()->json($response);
    }


    // function untuk item colaborative filtering 
    public function similarityDistance($preferences, $person1, $person2)
    {
        $similar = array();
        $sum = 0;
    
        foreach($preferences[$person1] as $key=>$value)
        {
            if(array_key_exists($key, $preferences[$person2]))
                $similar[$key] = 1;
        }
        
        if(count($similar) == 0)
            return 0;
        
        foreach($preferences[$person1] as $key=>$value)
        {
            if(array_key_exists($key, $preferences[$person2]))
                $sum = $sum + pow($value - $preferences[$person2][$key], 2);
        }
        
        return  1/(1 + sqrt($sum));     
    }
    
    
    public function matchItems($preferences, $person)
    {
        $score = array();
        
            foreach($preferences as $otherPerson=>$values)
            {
                if($otherPerson !== $person)
                {
                    $sim = $this->similarityDistance($preferences, $person, $otherPerson);
                    
                    if($sim > 0)
                        $score[$otherPerson] = $sim;
                }
            }
        
        array_multisort($score, SORT_DESC);
        return $score;
    
    }
    
    
    public function transformPreferences($preferences)
    {
        $result = array();
        
        foreach($preferences as $otherPerson => $values)
        {
            foreach($values as $key => $value)
            {
                $result[$key][$otherPerson] = $value;
            }
        }
        
        return $result;
    }
    
    
    public function getRecommendations($kumpulan_lapangan, $lapangan)
    {
        $total = [];
        $simSums = [];
        $ranks = [];
        $sim = 0;
        
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
                    if(!array_key_exists($key, $preferences[$person]))
                    {
                        if(!array_key_exists($key, $total)) {
                            $total[$key] = 0;
                        }
                        $total[$key] += $preferences[$otherPerson][$key] * $sim;
                        
                        if(!array_key_exists($key, $simSums)) {
                            $simSums[$key] = 0;
                        }
                        $simSums[$key] += $sim;
                    }
                }
                
            }
        }

        foreach($total as $key=>$value)
        {
            $ranks[$key] = $value / $simSums[$key];
        }
        
        array_multisort($ranks, SORT_DESC);    
        return $ranks;
        
    }
}
