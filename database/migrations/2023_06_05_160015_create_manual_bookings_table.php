<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManualBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manual_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id');
            $table->string('customer_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->date('booking_start_date');
            $table->date('booking_end_date');
            $table->double('advance_amnt' , [20,2]);
            $table->double('pending_amnt' , [20,2]);
            $table->double('total_amnt' , [20,2]);
            $table->enum('status' , ['PENDING' , 'COMPLETED' , 'CANCELLED' ])->default('PENDING');
            $table->unsignedBigInteger('created_by_id');
            $table->foreign('created_by_id')->references('id')->on('users')->cascadeOnDelete();
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
        Schema::dropIfExists('manual_bookings');
    }
}
