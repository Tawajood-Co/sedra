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
        Schema::create('barcode_templats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone',25);
            $table->string('country_code', 5);
            $table->string('passport');
            $table->string('passport_img');
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
