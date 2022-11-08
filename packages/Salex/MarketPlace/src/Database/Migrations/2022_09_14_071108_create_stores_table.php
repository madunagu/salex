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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('url')->nullable();
            $table->boolean('is_visible')->default(0);
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('telegram')->nullable();
            $table->string('name')->nullable();

            $table->tinyInteger('status')->default(0);
            $table->boolean('featured')->default(0);
            $table->unsignedInteger('category_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('geolocation')->nullable();
            $table->boolean('is_physical')->default(0);
            $table->unsignedInteger('state_id')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('image')->nullable();
            $table->integer('owner_id')->default(0);
            // $table->foreign('state_id')->references('id')->on('country_states')->onDelete('set null');
            // $table->foreign('category_id')->references('id')->on('store_categories')->onDelete('set null');
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
        Schema::dropIfExists('stores');
    }
};
