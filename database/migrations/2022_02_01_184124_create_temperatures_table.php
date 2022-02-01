<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemperaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temperatures', function (Blueprint $table) {
            $table->id();
            $table->timestampTz('time_instant');
            $table->timestampTz('model_run_at');
            $table->integer('value');
            $table->timestamps();
        });

        Schema::table('temperatures', function (Blueprint $table) {
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
        Schema::table('temperatures', function (Blueprint $table) {
            $table->dropForeign(['forecast_id']);

        });

        Schema::dropIfExists('temperatures');
    }
}
