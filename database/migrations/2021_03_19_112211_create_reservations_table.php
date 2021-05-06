<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id')->unsigned()->nullable();
            $table->string('customer_name');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->bigInteger('room_type_id')->unsigned();
            $table->bigInteger('pan_type_id')->unsigned();
            $table->bigInteger('room_id')->unsigned();
            $table->tinyInteger('use_type_id')->unsigned();
            $table->tinyInteger('status_id')->unsigned();
            $table->double('price')->unsigned();
            $table->boolean('invoice')->default(0);
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
        Schema::dropIfExists('reservations');
    }
}
