<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VehicleDiscount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles_discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('vehicle_type');
            $table->string('vehicle_category');
            $table->string('vehicle_number');
            $table->string('discount_code');
            $table->string('discount_type');
            $table->string('discount_amount');
            $table->string('status');
            $table->string('start_at');
            $table->string('expired_at');
            $table->timestamps();

            $table->unique(['discount_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles_discounts');
    }
}