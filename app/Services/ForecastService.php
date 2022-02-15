<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Place;
use App\Models\Forecast;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ForecastService
{

    /**
     * Adds Forecast objects to the database associated to a given Place.
     *
     * @param Array $day API Provided day data
     * @return Forecast
     **/
    public static function create(Place $place, string $beginAt, string $endAt): Forecast
    {
        $parsedBeginAt = Carbon::parse($beginAt)->format('Y-m-d H:i:s');
        $parsedEndAt = Carbon::parse($endAt)->format('Y-m-d H:i:s');

        $forecast = Forecast::create([
            'place_id' => $place->id,
            'begin_at' => $parsedBeginAt,
            'end_at' => $parsedEndAt
        ]);

        Log::channel('forecast')->info('Stored a forecast for the period between ' . $forecast->begin_at . ' and ' . $forecast->end_at . '...');

        return $forecast;
    }

    /**
     * Find a forecast object giving a place id and the end date of the forecast.
     *
     * @param Place $place Place object
     * @param string $beginAt Start date
     * @param string $endAt End date
     * @return Forecast
     * @throws ModelNotFoundException
     **/
    public static function findOneByDateAndPlace(Place $place, string $endAt): Forecast
    {
        $parsedEndAt = Carbon::parse($endAt)->format('Y-m-d');

        try {
            $forecast = Forecast::whereDate('end_at', '=', $parsedEndAt)
                ->where('place_id', '=', $place->id)
                ->firstOrFail();
        }
        catch (ModelNotFoundException $e) {
            Log::channel('forecast')->error('No forecast por the place id '. $place->id .' found for the day' . $parsedEndAt . '...');
            throw $e;
        }

        Log::channel('forecast')->info('Retriving the forecast for the period between ' . $forecast->begin_at . ' and ' . $forecast->end_at . '...');
        return $forecast;
    }

    /**
     * Find a forecast object giving a place id and the end date of the forecast.
     *
     * @param Place $place Place object
     * @param string $beginAt Start date
     * @param string $endAt End date
     * @return Collection
     * @throws ModelNotFoundException
     **/
    public static function findAllByDateAndPlace(Place $place, string $beginAt, string $endAt): Collection
    {
        $forecastCollection = new Collection();
        $parsedBeginAt = Carbon::parse($beginAt)->format('Y-m-d');
        $parsedEndAt = Carbon::parse($endAt)->format('Y-m-d');
        $period = CarbonPeriod::create($parsedBeginAt, $parsedEndAt);

        // Iterate over the period
        foreach ($period as $date) {
            try {
                $forecast = Forecast::whereDate('end_at', '=', $date)
                    ->where('place_id', '=', $place->id)
                    ->first();
                $forecastCollection->add($forecast);
            }
            catch (ModelNotFoundException $e) {
                Log::channel('forecast')->error('No forecast por the place id '. $place->id .' found for the day' . $parsedEndAt . '...');
                throw $e;
            }
        }



        Log::channel('forecast')->info('Retriving the forecasts for the period between ' . $parsedBeginAt . ' and ' . $parsedEndAt . '...');
        Log::debug($forecastCollection);
        return $forecastCollection;
    }

}
