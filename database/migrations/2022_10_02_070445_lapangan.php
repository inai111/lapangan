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
        Schema::create('lapangan',function(Blueprint $table){
            $table->id();
            $table->foreignId('merchant_id');
            $table->foreignId('jenis_olahraga_id');
            $table->string('nama');
            $table->string('harga');
            $table->string('cover');
            $table->string('type');
            $table->text('deskripsi')->nullable();
            $table->enum('status',['ada','tidak_ada'])->default('ada');
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
