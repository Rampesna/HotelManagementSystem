<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSafeActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('safe_activities', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('safe_id')->unsigned();
            $table->bigInteger('reservation_id')->unsigned();
            $table->bigInteger('process_id')->unsigned()->nullable();
            $table->boolean('direction');
            $table->double('price')->unsigned();
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
        Schema::dropIfExists('safe_activities');
    }
}
