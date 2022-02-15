<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

use App\Models\Forecast;
use App\Models\Precipitation;

use Carbon\Carbon;

class PrecipitationService
{

    /**
     * Adds Precipitation objects to the database associated to a given Forecast.
     *
     * @param Forecast $forecast Forecast entity
     * @param Array $hourlyValue API Provided precipitation data
     * @return Precipitation
     **/
    public static function create(Forecast $forecast, array $hourlyValue)
    {
        $precipitation = Precipitation::create([
            'forecast_id' => $forecast->id,
            'time_instant' => Carbon::parse($hourlyValue['timeInstant'])->setTimezone('UTC')->format('Y-m-d H:i:s'),
            'model_run_at' => Carbon::parse($hourlyValue['modelRun'])->setTimezone('UTC')->format('Y-m-d H:i:s'),
            'value' => $hourlyValue['value'],
        ]);

        Log::channel('forecast')->info('Created a new precipitation for the forecast ' . $forecast->id . ' and the time instant ' . $precipitation->time_instant . '...');

        return $precipitation;
    }

}
