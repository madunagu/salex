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
        Schema::create('store_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->string('status');
            $table->string('name');
            $table->unsignedInteger('store_id');
            $table->unsignedInteger('customer_id')->nullable();
            // $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            // $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
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
        Schema::dropIfExists('store_reviews');
    }
};
