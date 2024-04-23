<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_docs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('driver_id');
            $table->foreign('driver_id')->references('id')->on('users')->cascadeOnDelete();
            $table->string('driver_licence_front_pic')->nullable();
            $table->string('driver_licence_back_pic')->nullable();
            $table->string('car_pic')->nullable();
            $table->string('electricity_bill_pic')->nullable();
            $table->string('bank_check_book_pic')->nullable();
            $table->string('car_front_side_pic')->nullable();
            $table->string('car_back_side_pic')->nullable();
            $table->string('car_registration_pic')->nullable();
            $table->string('car_tax_token_licence')->nullable();
            $table->string('car_fitness_licence')->nullable();
            $table->string('car_insurance_licence')->nullable();
            $table->string('car_route_permit_licence')->nullable();
            $table->string('add_extra_pic')->nullable();
            $table->enum('gps_tracking', ['yes' , 'no'])->default('no');
            $table->string('cctv_sur')->nullable();
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
        Schema::dropIfExists('driver_docs');
    }
}
