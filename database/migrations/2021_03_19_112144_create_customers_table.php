<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id')->nullable();
            $table->string('name');
            $table->string('surname');
            $table->string('title')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->bigInteger('nationality_id')->nullable();
            $table->boolean('gender')->nullable();
            $table->boolean('marriage')->nullable();
            $table->tinyInteger('identity_type_id')->unsigned()->nullable();
            $table->date('identity_expiration_date')->nullable();
            $table->string('identity_number');
            $table->string('passport_number')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('father_name')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
