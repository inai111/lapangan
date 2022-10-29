<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('booklists',function(Blueprint $table){
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('lapangan_id');
            $table->dateTime('jam_awal')->nullable();
            $table->dateTime('jam_akhir')->nullable();
            $table->integer('length');
            $table->enum('type_pembayaran',['cash','transfer']);
            $table->enum('status',['pending','on_going','complete','cancel']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
