<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuitarimagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guitarimages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image_uri');
            $table->integer('guitar_id')->unsigned();
            $table->foreign('guitar_id')->references('id')->on('guitars');
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
        Schema::dropIfExists('guitarimages');
    }
}
