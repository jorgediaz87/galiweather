<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

use App\Models\Forecast;
use App\Models\Temperature;

use Carbon\Carbon;

class TemperatureService
{

    /**
     * Adds Temperature objects to the database associated to a given Forecast.
     *
     * @param Forecast $forecast Forecast entity
     * @param Array $hourlyValue API Provided temperature data
     * @return Temperature
     **/
    public static function create(Forecast $forecast, array $hourlyValue)
    {
        $temperature = Temperature::create([
            'forecast_id' => $forecast->id,
            'time_instant' => Carbon::parse($hourlyValue['timeInstant'])->setTimezone('UTC')->format('Y-m-d H:i:s'),
            'model_run_at' => Carbon::parse($hourlyValue['modelRun'])->setTimezone('UTC')->format('Y-m-d H:i:s'),
            'value' => $hourlyValue['value'],
        ]);

        Log::channel('forecast')->info('Created a new temperature for the forecast ' . $forecast->id . ' and the time instant ' . $temperature->time_instant . '...');

        return $temperature;
    }

}
