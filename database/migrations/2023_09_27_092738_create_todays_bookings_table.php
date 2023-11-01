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
        Schema::create('todays_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->nullable();
            $table->string('user_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('artist')->nullable();
            $table->string('location')->nullable();
            $table->string('services')->nullable();
            $table->string('artist_prize')->nullable();
            $table->string('c_w_discount')->nullable();
            $table->string('net_amount')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('astatus')->default('in_progress');
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('todays_bookings');
    }
};
