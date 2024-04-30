<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DriverInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_infos', function ($table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('number')->nullable();
            $table->integer('address')->nullable();
            $table->integer('experience_in_car');
            $table->integer('experience_in_year');
            $table->integer('licence_number');
            $table->integer('nid_number');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_infos');
    }
}