<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

use App\Models\Place;
use App\Models\Forecast;

use Carbon\Carbon;

class CreateForecastService
{

    /**
     * Adds Forecast objects to the database associated to a given Place.
     *
     * @param Array $day API Provided day data
     * @return Wind
     **/
    public static function create(Place $place, array $day)
    {
        $forecast = Forecast::create([
            'place_id' => $place->id,
            'begin_at' => Carbon::parse($day['timePeriod']['begin']['timeInstant'])->setTimezone('UTC')->format('Y-m-d H:i:s'),
            'end_at' => Carbon::parse($day['timePeriod']['end']['timeInstant'])->setTimezone('UTC')->format('Y-m-d H:i:s')
        ]);

        Log::channel('forecast')->info('Stored a forecast for the period between ' . $forecast->begin_at . ' and ' . $forecast->end_at . '...');

        return $forecast;
    }

}
