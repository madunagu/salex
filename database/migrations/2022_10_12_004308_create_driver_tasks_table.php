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
        Schema::create('driver_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('driver_id');
            // $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');

            $table->unsignedBigInteger('shipment_id');
            // $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('cascade');

            $table->string('barcode')->nullable();
            $table->string('status')->default('draft');

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
        Schema::dropIfExists('driver_tasks');
    }
};
