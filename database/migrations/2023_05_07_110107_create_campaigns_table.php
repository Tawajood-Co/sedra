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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('program')->comment('1 => Makkah, 2 => Makkah and Madinah');
            $table->string('img');
            $table->bigInteger('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->bigInteger('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->double('single_price', 7, 1);
            $table->double('double_price', 7, 1);
            $table->double('rate', 2, 1)->default(0);
            $table->integer('rate_count')->default(0);
            $table->boolean('status')->default(true);
            $table->integer('persons_count');
            $table->integer('available_places');
            $table->boolean('distinct')->default(0);
            $table->bigInteger('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->string('address')->nullable();
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
        Schema::dropIfExists('campaigns');
    }
};
