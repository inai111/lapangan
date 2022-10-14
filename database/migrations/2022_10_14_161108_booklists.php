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
            $table->dateTime('jam_awal');
            $table->dateTime('jam_akhir');
            $table->enum('type',['futsal','bulu_tangkis','volley']);
            $table->enum('status',['pending','complete','cancel']);
            $table->integer('kuantitas')->default(1);
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
