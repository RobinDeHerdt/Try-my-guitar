<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuitarTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guitar_type', function (Blueprint $table) {
            $table->integer('guitar_id')->unsigned();
            $table->foreign('guitar_id')->references('id')->on('guitars');
            $table->integer('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('guitar_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guitar_type');
    }
}
