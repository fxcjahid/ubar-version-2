<?php

/** 
 * Creating Referral Database.
 * @author Fxc Jahid <fxcjahid3@gmail.com>
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Referral extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->integer('referral_code');
            $table->integer('referred_id');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['referral_code', 'referred_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referral');
    }
}