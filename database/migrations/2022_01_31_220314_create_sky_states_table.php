<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkyStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sky_states', function (Blueprint $table) {
            $table->id();
            $table->foreign('forecast_id')->references('id')->on('forecasts');
            $table->timestampTz('time_instant');
            $table->timestampTz('model_run_at');
            $table->enum('value',
                [
                    'SUNNY', 'HIGH_CLOUDS,', 'PARTLY_CLOUDY,',
                    'OVERCAST', 'CLOUDY', 'FOG', 'SHOWERS',
                    'OVERCAST_AND_SHOWERS', 'INTERMITENT_SNOW','INTERMITENT_SNOW',
                    'RAIN','SNOW','STORMS','MIST','FOG_BANK','MID_CLOUDS',
                    'WEAK_RAIN','WEAK_SHOWERS','STORM_THEN_CLOUDY','MELTED_SNOW'
                ]
            );
            $table->string('value');
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
        Schema::dropIfExists('sky_states');
    }
}
