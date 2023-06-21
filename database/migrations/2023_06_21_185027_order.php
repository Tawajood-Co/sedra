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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('voucher_id')->unsigned()->nullable();
            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('cascade');
            $table->double('price_after_discount')->default(0);
            $table->double('price_before_discount')->default(0);
            $table->Integer('payment_type')->default(0)->comment('1 wallet  2 bank    3 visa');
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
