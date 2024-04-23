<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('username')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('profile_pic')->nullable();
            $table->string('speed')->nullable();
            $table->string('heading')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->enum('is_online' , ['online' , 'offline'])->default('offline');
            $table->string('app_token')->nullable();
            $table->tinyInteger('is_phone_verified')->default(0);
            $table->string('reset_hash')->nullable();
            $table->string('reset_at')->nullable();
            $table->string('reset_expires')->nullable();
            $table->string('activate_hash')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->text('status_message')->nullable();
            $table->tinyInteger('active')->default(0);
            $table->string('verification_code')->nullable();
            $table->double('points')->nullable();
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
        Schema::dropIfExists('users');
    }
}
