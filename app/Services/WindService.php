<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

use App\Models\Forecast;
use App\Models\Wind;

use Carbon\Carbon;

class WindService
{

    /**
     * Adds Temperature objects to the database associated to a given Forecast.
     *
     * @param Forecast $forecast Forecast entity
     * @param Array $hourlyValue API Provided wind data
     * @return Wind
     **/
    public static function create(Forecast $forecast, array $hourlyValue)
    {
        $wind = Wind::create([
            'forecast_id' => $forecast->id,
            'time_instant' => Carbon::parse($hourlyValue['timeInstant'])->format('Y-m-d H:i:s'),
            'model_run_at' => Carbon::parse($hourlyValue['modelRun'])->format('Y-m-d H:i:s'),
            'model_value' => $hourlyValue['moduleValue'],
            'direction_value' => $hourlyValue['directionValue'],
        ]);

        Log::channel('forecast')->info('Created a new wind for the forecast ' . $forecast->id . ' and the time instant ' . $wind->time_instant . '...');

        return $wind;
    }

}
