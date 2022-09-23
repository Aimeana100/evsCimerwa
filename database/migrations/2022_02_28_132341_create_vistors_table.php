<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVistorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vistors', function (Blueprint $table) {
            $table->id();
            $table->string('names');
            $table->string('ID_Card',100)->nullable()->comment('NID or custom Card ID');
            $table->string('phone')->nullable();
            $table->string('issuedate')->nullable();
            $table->string('destination')->nullable()->comment('text describing specific location');
            $table->date('dateJoined')->comment('first time tap');
            $table->date('latestTap')->comment('the latest card tap');
            $table->enum('reason', ['OWNS', 'LOST','UNDER'])->comment('OWNS,LOST, UNDER - has , lost NID_card or Under_age');
            $table->string('status',10)->comment('IN or OUT not ENTERING and EXITING is for cardTaps table');
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
        Schema::dropIfExists('vistors');
    }
}
