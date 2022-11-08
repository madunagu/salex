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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('address');
            $table->string('identity_number');
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->string('avatar')->nullable();
            $table->string('image')->nullable();
            $table->string('cnic')->nullable();
            $table->string('password');
            $table->boolean('status')->default(true);
            $table->boolean('is_suspended')->default(false);
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
        Schema::dropIfExists('drivers');
    }
};
