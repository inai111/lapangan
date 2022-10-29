<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class user extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('user')->insert([
            'name' => Str::random(10),
            'username' => 'user',
            'password' => Hash::make('1'),
            'photo' => "default.jpg",
            'number' => "888888",
            'level' => "user",
            'active' => "activated",
            'created_at'=>now(),
        ]);
        DB::table('user')->insert([
            'name' => Str::random(10),
            'username' => 'admin',
            'password' => Hash::make('1'),
            'photo' => "default.jpg",
            'number' => "888888",
            'level' => "user",
            'active' => "activated",
            'created_at'=>now(),
        ]);
        DB::table('galleries')->insert([
            'photo' => "default.png",
            'ref_id' => '1',
            'created_at'=>now(),
        ]);
        DB::table('galleries')->insert([
            'photo' => "default.png",
            'ref_id' => '1',
            'created_at'=>now(),
        ]);
        DB::table('galleries')->insert([
            'photo' => "default.png",
            'ref_id' => '1',
            'created_at'=>now(),
        ]);
        DB::table('galleries')->insert([
            'photo' => "default.png",
            'ref_id' => '1',
            'created_at'=>now(),
        ]);
        DB::table('merchants')->insert(
            [
            ['name_merchant' => Str::random(10),
            'address' => "tidak ada alamat yang jelas",
            'number' => "888888",
            'active' => "pending",
            'bank' => "bank bank an",
            'bank_number' => "10129388712",
            'open'=>'09:00:00',
            'close'=>'21:00:00',
            'user_id' => 1,
            'created_at'=>now(),],
            ['name_merchant' => Str::random(10),
            'address' => "tidak ada alamat yang jelas",
            'number' => "888888",
            'active' => "pending",
            'bank' => "bank bank an",
            'bank_number' => "10129388712",
            'open'=>'09:00:00',
            'close'=>'21:00:00',
            'user_id' => 1,
            'created_at'=>now(),]
            ]
        );
        DB::table('lapangan')->insert([
            [
                'nama'=>'lapangan A',
                'harga'=>'210000',
                'type'=>'Volley',
                'cover'=>"default.png",
                'merchant_id'=>1,
                'additional_info'=> "- Tersedia banyak dan selalu ready, silahkan langsung order
                - Dijamin dikirim di hari yang sama
                WARNA KAMI KIRIM RANDPM SESUAI YG ADA DI STOK KAMI 😍😍
                
                UNTUK RANDOM REQUEST WARNA BERIKAN NOTE ( HITAM ADA VARIASI TERSENDIRI)
                
                - Tongkat bisa dipanjang pendekkan dari 24 cm menjadi sampai 65 cm, untuk memudahkan dalam menyimpan.
                - Tongkat fleksibel untuk mempermudah membayar tol dengan kartu atau dapat digunakan dengan kartu akses lainnya.
                - Ukuran yang lebih kecil, lebih ramping dan sangat ringan untuk memudahkan saat dipakai.
                - Ketahanan yang kuat di ujung kepala kartu agar lebih mudah dalam menge tap
                - Pegangan handle dengan soft grip mengikuti sela jari agar tidak mudah terjatuh
                - BAHAN ALUMUNIUM (bukan plastik)
                
                Highlight:
                - Kartu tidak akan jatuh saat tapping atau terselip.
                - Disaat hujan tidak membasahi pakaian atau tangan pengendara saat melakukan tapping
                - mempermudah pengguna mobil sedan saat bertransaksi di GTO / gerbang akses
                - mengurangi resiko baret pada mobil yang disebabkan gesekan mobil dan trotoar
                - Pengguna e toll dapat bertransaksi lebih cepat
                - Tongkat kuat dan tidak mudah patah
                - Ujung stick sangat lentur, sehingga memudahkan pengguna untuk tapping e Toll atau kartu akses lainnya.
                - Pengguna e toll yang menginginkan transaksi lebih cepat dan mudah tanpa harus membeli ON BOARD UNIT ( OBU ) dengan harga yang mahal
                - E toll terkadang sulit ditemukan atau pada saat digunakan sangat mudah terjatuh,",
                'created_at'=>now()
            ]
        ]);
        DB::table('booklists')->insert([
            'user_id' => "1",
            'lapangan_id' => '1',
            'jam_awal' => date("Y-m-d H:00:00",strtotime("+3Hour")),
            'jam_akhir' => date("Y-m-d H:00:00",strtotime("+4Hour")),
            'length'=>'1',
            "type_pembayaran"=>'cash',
            "status"=>'pending',
            'created_at'=>now(),
        ]);
        DB::table('booklists')->insert([
            'user_id' => "1",
            'lapangan_id' => '1',
            'jam_awal' => date("Y-m-d H:00:00",strtotime("+4Hour")),
            'jam_akhir' => date("Y-m-d H:00:00",strtotime("+6Hour")),
            'length'=>'2',
            "type_pembayaran"=>'cash',
            "status"=>'pending',
            'created_at'=>now(),
        ]);
        DB::table('booklists')->insert([
            'user_id' => "1",
            'lapangan_id' => '1',
            'jam_awal' => date("Y-m-d H:00:00",strtotime("+8Hour")),
            'jam_akhir' => date("Y-m-d H:00:00",strtotime("+10Hour")),
            'length'=>'2',
            "type_pembayaran"=>'cash',
            "status"=>'pending',
            'created_at'=>now(),
        ]);
        DB::table('booklists')->insert([
            'user_id' => "1",
            'lapangan_id' => '1',
            'jam_awal' => null,
            'jam_akhir' => null,
            'length'=>'2',
            "type_pembayaran"=>'cash',
            "status"=>'pending',
            'created_at'=>now(),
        ]);
    }
}
