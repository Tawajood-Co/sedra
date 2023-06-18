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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone',25);
            $table->string('country_code', 5);
            $table->string('email');
            $table->string('logo');
            $table->string('password');
            //$table->string('fcm_token');
            $table->string('lang', 10);
            $table->boolean('status')->default(true);
            $table->string('otp')->nullable();
            $table->boolean('notify')->default(true);
            $table->double('rate',2,1)->nullable();
            $table->integer('total_rate')->nullable();
            $table->double('balance', 12, 2)->default(0.00);
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
        Schema::dropIfExists('companies');
    }
};
