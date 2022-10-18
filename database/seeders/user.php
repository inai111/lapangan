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
            'username' => 'admin',
            'password' => Hash::make('1'),
            'photo' => "default.jpg",
            'number' => "888888",
            'level' => "user",
            'active' => "activated",
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
            'user_id' => 1,
            'created_at'=>now(),],
            ['name_merchant' => Str::random(10),
            'address' => "tidak ada alamat yang jelas",
            'number' => "888888",
            'active' => "pending",
            'bank' => "bank bank an",
            'bank_number' => "10129388712",
            'user_id' => 1,
            'created_at'=>now(),]
            ]
        );
    }
}
