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
        Schema::table('shipments', function (Blueprint $table) {
            $table->integer('driver_id')->default(0);
            $table->string('direction')->default('deliver');
            $table->dateTime('delivered_at')->nullable();
            $table->dateTime('pickedup_at')->nullable();
            $table->string('dropoff_code')->nullable();
            $table->dateTime('notification_sent_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropIfExists('driver_id');
        });
    }
};
