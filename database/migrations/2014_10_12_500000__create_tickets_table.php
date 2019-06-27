<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('record_id');
            $table->unsignedInteger('closed_by_id')->nullable();
            $table->enum('status', ['open', 'close'])->default('open');
            $table->string('comments')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'record_id']);

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('closed_by_id')
                ->references('id')
                ->on('users');

            $table->foreign('record_id')
                ->references('id')
                ->on('records')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
