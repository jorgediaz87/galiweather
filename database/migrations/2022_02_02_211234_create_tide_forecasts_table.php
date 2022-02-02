<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTideForecastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tide_forecasts', function (Blueprint $table) {
            $table->id();
            $table->timestampTz('begin_at');
            $table->timestampTz('end_at');
            $table->timestamps();
        });

        Schema::table('tide_forecasts', function (Blueprint $table) {
            $table->foreignId('place_id')
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
        Schema::table('tide_forecasts', function (Blueprint $table) {
            $table->dropForeign(['place_id']);
        });

        Schema::dropIfExists('tide_forecasts');
    }
}
