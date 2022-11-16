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
        Schema::create('merchants',function(Blueprint $table){
            $table->id();
            $table->string('name_merchant');
            $table->string('address');
            $table->string('number');
            $table->enum('active',['active','pending','suspended','rejected'])->default('pending');
            $table->string('bank');
            $table->foreignId('user_id');
            $table->string('bank_number');
            $table->time('open');
            $table->time('close');
            $table->enum('status_close',['open','close'])->default('open');
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
