<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoursDayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hours_day', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->date('from_date');
            $table->unsignedInteger('monday')->nullable();
            $table->unsignedInteger('tuesday')->nullable();
            $table->unsignedInteger('wednesday')->nullable();
            $table->unsignedInteger('thursday')->nullable();
            $table->unsignedInteger('friday')->nullable();
            $table->unsignedInteger('saturday')->nullable();
            $table->unsignedInteger('sunday')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_entries');
    }
}
