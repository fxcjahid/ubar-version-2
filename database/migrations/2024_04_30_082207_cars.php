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
            $table->string('owner_mobile_number');
            $table->string('owner_nid_number');
            $table->string('model_name');
            $table->string('car_number');
            $table->string('registration_number');
            $table->string('color_name');
            $table->string('engine_number');
            $table->string('cc_number');
            $table->string('seats_number');
            $table->string('chassize_number');
            $table->string('bluebook_number');
            $table->string('route_permit_number');
            $table->string('fleetness_number');
            $table->date('fitness_ensuring_at');
            $table->date('fitness_expired_at');
            $table->integer('insurance_number');
            $table->string('tax_token_number');
            $table->string('ride_service')->nullable();
            $table->string('ride_package')->nullable();
            $table->string('gps_tracking')->default(1);
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