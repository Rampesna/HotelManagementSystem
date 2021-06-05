<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHandOversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hand_overs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('from')->unsigned()->nullable();
            $table->bigInteger('to')->unsigned()->nullable();
            $table->longText('receipts')->nullable();
            $table->double('safe_total')->unsigned()->nullable();
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
        Schema::dropIfExists('hand_overs');
    }
}
