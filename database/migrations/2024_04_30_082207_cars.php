<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Cars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function ($table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('owner_name');
            $table->string('owner_bank_acc')->nullable();
            $table->integer('owner_mobile_number');
            $table->integer('owner_nid_number');
            $table->string('model_name');
            $table->integer('car_number');
            $table->integer('registration_number');
            $table->string('color_name');
            $table->integer('engine_number');
            $table->integer('cc_number');
            $table->integer('seats_number');
            $table->integer('chassize_number');
            $table->integer('bluebook_number');
            $table->integer('route_permit_number');
            $table->integer('fleetness_number');
            $table->date('fitness_ensuring_at');
            $table->date('fitness_expired_at');
            $table->integer('insurance_number');
            $table->integer('tax_token_number');
            $table->string('ride_service')->nullable();
            $table->string('ride_package')->nullable();
            $table->boolean('gps_tracking')->default(1);
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
        Schema::dropIfExists('cars');
    }
}