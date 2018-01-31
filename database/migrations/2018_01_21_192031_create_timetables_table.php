<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetables', function (Blueprint $table) {
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

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        DB::getPdo()->exec('
            CREATE TRIGGER timetable_after_insert_user AFTER INSERT ON users
            FOR EACH ROW
            BEGIN
                INSERT INTO timetables
                (user_id, from_date, monday, tuesday, wednesday, thursday, friday)
                VALUES
                (NEW.id, SYSDATE(), 29700, 29700, 29700, 29700, 29700);
            END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timetables');
    }
}
