<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardTapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_taps', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->comment('the foreign key of the visitor or staff dpending on the card_type');
            $table->dateTime('tapped_at')->comment('Current time stamp');
            $table->string('ID_Card')->nullable()->comment('NID or custom card_id');
            $table->string('card_type')->comment('STAFF or VISITOR');
            $table->string('status',10)->comment('ENTERING or EXITING');
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
        Schema::dropIfExists('card_taps');
    }
}