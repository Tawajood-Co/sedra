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
        Schema::create('product_feature_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_feature_id')->unsigned();
            $table->string('locale')->index();
            $table->string('feature');
            $table->string('value');
            $table->unique(['product_feature_id', 'locale']);
            $table->foreign('product_feature_id')->references('id')->on('product_features')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_feature_translations');
    }
};
