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
            $table->integer('length')->default(1);
            $table->integer('rating')->nullable();
            $table->text('review')->nullable();
            $table->string('down_payment')->nullable();
            $table->string('total_biaya');
            $table->string('kasir')->nullable();
            $table->dateTime('tanggal_bayar')->nullable();
            $table->enum('jenis_pembayaran',['cash','transfer','both']);
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
