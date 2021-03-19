<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('room_status_id')->unsigned();
            $table->bigInteger('room_type_id')->unsigned();
            $table->bigInteger('pan_type_id')->unsigned();
            $table->bigInteger('bad_type_id')->unsigned();
            $table->string('number')->unique();
            $table->tinyInteger('person_count')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
