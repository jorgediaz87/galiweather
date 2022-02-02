<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolarInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solar_infos', function (Blueprint $table) {
            $table->id();
            $table->time('sunrise');
            $table->time('midday');
            $table->time('sunset');
            $table->string('duration');
            $table->timestamps();
        });

        Schema::table('solar_infos', function (Blueprint $table) {
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
        Schema::table('solar_infos', function (Blueprint $table) {
            $table->dropForeign(['forecast_id']);
        });

        Schema::dropIfExists('solar_infos');
    }
}
