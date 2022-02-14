<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tides', function (Blueprint $table) {
            $table->id();
            $table->timestampTz('time_instant');
            $table->enum('state',
                [
                    'High tides', 'Low tides'
                ]
            );
            $table->float('height');
        });


        Schema::table('tides', function (Blueprint $table) {
            $table->foreignId('forecast_id')
                ->constrained()
                ->onUpdate('cascade')
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
        Schema::table('tides', function (Blueprint $table) {
            $table->dropForeign(['forecast_id']);
        });

        Schema::dropIfExists('tides');
    }
}
