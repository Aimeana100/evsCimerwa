<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('names');
            $table->string('gender', 10)->nullable();
            $table->string('category');
            $table->string('department');
            $table->string('phone')->nullable();
            $table->string('ID_Card')->comment('ID number');
            $table->string('company')->comment('the company that the labour from')->default('CIMERWA');
            $table->dateTime('dateJoined');
            $table->dateTime('latestTap');
            $table->string('status')->comment('Current status IN or OUT');
            $table->boolean('state')->default(true)->comment('the state that an employee is currently accepted or barned');
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
        Schema::dropIfExists('employees');
    }
}
