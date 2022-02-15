<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Place;
use App\Models\Forecast;

use Carbon\Carbon;

class CreateForecastService
{

    /**
     * Adds Forecast objects to the database associated to a given Place.
     *
     * @param Array $day API Provided day data
     * @return Forecast
     **/
    public static function create(Place $place, string $beginAt, string $endAt): Forecast
    {
        $parsedBeginAt = Carbon::parse($beginAt)->setTimezone('UTC')->format('Y-m-d H:i:s');
        $parsedEndAt = Carbon::parse($endAt)->setTimezone('UTC')->format('Y-m-d H:i:s');

        $forecast = Forecast::create([
            'place_id' => $place->id,
            'begin_at' => $parsedBeginAt,
            'end_at' => $parsedEndAt
        ]);

        Log::channel('forecast')->info('Stored a forecast for the period between ' . $forecast->begin_at . ' and ' . $forecast->end_at . '...');

        return $forecast;
    }

    /**
     * Finds forecast objects associated to a given Place and a start and end date
     *
     * @param Place $place Place object
     * @param string $beginAt Start date
     * @param string $endAt End date
     * @return Forecast
     * @throws ModelNotFoundException
     **/
    public static function findByDateAndPlace(Place $place, string $beginAt, string $endAt)
    {

        $parsedBeginAt = Carbon::parse($beginAt)->setTimezone('UTC')->format('Y-m-d');
        $parsedEndAt = Carbon::parse($endAt)->setTimezone('UTC')->format('Y-m-d');

        try {
            $forecast = Forecast::whereDate('begin_at', '=', $parsedBeginAt)
                ->whereDate('end_at', '=', $parsedEndAt)
                ->where('place_id', '=', $place->id)
                ->firstOrFail();
        }
        catch (ModelNotFoundException $e) {
            Log::channel('forecast')->error('No forecast por the place id '. $place->id .' found for the period between ' . $parsedBeginAt . ' and ' . $parsedEndAt . '...');
            throw $e;
        }

        Log::channel('forecast')->info('Retriving the forecast for the period between ' . $forecast->begin_at . ' and ' . $forecast->end_at . '...');
        return $forecast;
    }

}
