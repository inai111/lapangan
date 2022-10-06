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
            $table->string('photo')->default('default.jpg');
            $table->enum('active',['activated','deactivated','suspended'])->default('deactivated');
            $table->string('bank');
            $table->string('bank_number');
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
