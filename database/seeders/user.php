<?php

namespace Database\Seeders;

use App\Models\Lapangan;
use App\Models\Merchant;
use App\Models\User as ModelsUser;
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
        DB::table('jenis_olahraga')->insert([
            ['nama' => "Volley"],
            ['nama' => "Basket"],
            ['nama' => "Sepak Bola"],
            ['nama' => "Futsal"],
            ['nama' => "Badminton"],
            ['nama' => "Bowling"],
        ]);
        ModelsUser::factory()
        ->has(Merchant::factory()
        ->count(1))
        ->count(4)->state([
            'role'=>'merchant'
        ])->create();
        ModelsUser::factory()
        ->count(5)
        ->state(['role'=>'user'])->create();
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
