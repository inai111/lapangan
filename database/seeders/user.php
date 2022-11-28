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
            'nama' => Str::random(10),
            'alamat' => Str::random(10),
            'nomor' => "888888",
            'foto' => "default.png",
            'role' => "merchant",
            'username' => 'merchant',
            'password' => Hash::make('1'),
            'active' => "activated",
            'created_at'=>now(),
        ]);
        DB::table('user')->insert([
            'name' => Str::random(10),
            'alamat' => Str::random(10),
            'nomor' => "888888",
            'foto' => "default.png",
            'username' => 'user',
            'password' => Hash::make('1'),
            'role' => "user",
            'active' => "activated",
            'created_at'=>now(),
        ]);
        DB::table('user')->insert([
            'name' => Str::random(10),
            'alamat' => Str::random(10),
            'foto' => "default.png",
            'username' => 'admin',
            'password' => Hash::make('1'),
            'nomor' => "888888",
            'role' => "admin",
            'active' => "activated",
            'created_at'=>now(),
        ]);
        DB::table('galleries')->insert([
            'photo' => "default.png",
            'lapangan_id' => '1',
            'created_at'=>now(),
        ]);
        DB::table('galleries')->insert([
            'photo' => "default.png",
            'lapangan_id' => '1',
            'created_at'=>now(),
        ]);
        DB::table('galleries')->insert([
            'photo' => "default.png",
            'lapangan_id' => '1',
            'created_at'=>now(),
        ]);
        DB::table('galleries')->insert([
            'photo' => "default.png",
            'lapangan_id' => '1',
            'created_at'=>now(),
        ]);
        DB::table('merchants')->insert(
            [
            ['nama' => Str::random(10),
            'alamat' => "tidak ada alamat yang jelas",
            'nomor' => "888888",
            'status_merchant' => "active",
            'bank' => "bank bank an",
            'norek' => "10129388712",
            'buka'=>'09:00:00',
            'tutup'=>'21:00:00',
            'pembayaran'=>'both',
            'dp'=>1,
            'user_id' => 1,
            'created_at'=>now(),],
            ['nama' => Str::random(10),
            'alamat' => "tidak ada alamat yang jelas",
            'nomor' => "888888",
            'status_merchant' => "pending",
            'bank' => "bank bank an",
            'norek' => "10129388712",
            'buka'=>'09:00:00',
            'pembayaran'=>'both',
            'dp'=>1,
            'tutup'=>'21:00:00',
            'user_id' => 2,
            'created_at'=>now(),]
            ]
        );
        DB::table('lapangan')->insert([
            [
                'nama'=>'lapangan A',
                'harga'=>'210000',
                'jenis_olahraga_id'=>1,
                'merchant_id'=>1,
                'status'=>'ada',
                'cover'=>"default.png",
                'deskripsi'=> "- Tersedia banyak dan selalu ready, silahkan langsung order
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
        DB::table('fasilitas')->insert([
            ['fasilitas' => "wifi",
            'fasilitas_icon' => '<i class="fa-solid fa-wifi"></i>'],
            ['fasilitas' => "wifi",
            'fasilitas_icon' => '<i class="fa-solid fa-wifi"></i>'],
            ['fasilitas' => "wifi",
            'fasilitas_icon' => '<i class="fa-solid fa-wifi"></i>'],
            ['fasilitas' => "wifi",
            'fasilitas_icon' => '<i class="fa-solid fa-wifi"></i>'],
        ]);
    }
}
