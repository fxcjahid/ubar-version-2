<?php

use App\Models\CarBooking;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestedDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requested_drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_booking_id')->nullable()->constrained((new CarBooking())->getTable());
            $table->foreignId('driver_id')->nullable()->constrained((new User())->getTable());
            $table->foreignId('user_id')->nullable()->constrained((new User())->getTable());
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('requested_drivers');
    }
}
