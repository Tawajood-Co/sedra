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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone',25);
            $table->string('country_code', 5);
            $table->string('password');
            $table->string('passport');
            $table->string('passport_img');
            $table->tinyInteger('status');
            $table->boolean('notify');
            $table->string('fcm_token');
            $table->string('lang', 10);
            $table->string('otp');
            $table->double('wallet', 12, 2);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
