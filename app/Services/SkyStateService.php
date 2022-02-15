<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

use App\Models\Forecast;
use App\Models\SkyState;

use Carbon\Carbon;

class SkyStateService
{

    /**
     * Adds SkyState objects to the database associated to a given Forecast.
     *
     * @param Forecast $forecast Forecast entity
     * @param Array $hourlyValue API Provided SkyState data
     * @return SkyState
     **/
    public static function create(Forecast $forecast, array $hourlyValue)
    {
        $skyState = SkyState::create([
            'forecast_id' => $forecast->id,
            'time_instant' => Carbon::parse($hourlyValue['timeInstant'])->format('Y-m-d H:i:s'),
            'model_run_at' => Carbon::parse($hourlyValue['modelRun'])->format('Y-m-d H:i:s'),
            'value' => $hourlyValue['value'],
        ]);

        Log::channel('forecast')->info('Created a new sky state for the forecast ' . $forecast->id . ' and the time instant ' . $skyState->time_instant . '...');

        return $skyState;
    }

}
