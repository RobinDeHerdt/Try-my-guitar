<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('image_uri')->default('images/profile.png');
            $table->string('password')->nullable();
            $table->double('location_lat')->nullable();
            $table->double('location_lng')->nullable();
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->string('header_image_uri')->default('images/electric-guitars.jpg');
            $table->boolean('verified')->default(false);
            $table->string('verification_token')->nullable();
            $table->integer('exp')->default(0);
            $table->boolean('active')->default(true);
            $table->date('inactive_until')->nullable();
            $table->string('twitter_id')->nullable();
            $table->rememberToken();
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
