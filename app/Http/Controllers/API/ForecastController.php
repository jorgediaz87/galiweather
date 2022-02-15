<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Place;
use App\Models\Forecast;
use App\Http\Resources\ForecastResource;
use App\Services\ForecastService;

class ForecastController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $placeID)
    {

        $place = Place::find($placeID);
        $forecasts = Forecast::where('place_id', $placeID)->get();
        Log::channel('forecast')->info('Forecasts fetched for place: ' . $place->name);
        return $this->sendResponse(ForecastResource::collection($forecasts), 'Forecasts fetched for place: ' . $place->name);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $placeID, Request $request)
    {
        $beginAt = $request->input('begin_at') ?? null;
        $endAt = $request->input('end_at');
        $place = Place::find($placeID);

        if (!$beginAt) {
            $forecast = ForecastService::findOneByDateAndPlace($place, $endAt);
            Log::channel('forecast')->info('Forecasts fetched for place: ' . $place->name. ' between ' . $beginAt . ' and ' . $endAt);
            return $this->sendResponse(new ForecastResource($forecast), 'Forecasts fetched for place: ' . $place->name);
        }

        $forecasts = ForecastService::findAllByDateAndPlace($place, $beginAt, $endAt);
        Log::channel('forecast')->info('Forecasts fetched for place: ' . $place->name. ' between ' . $beginAt . ' and ' . $endAt);
        return $this->sendResponse(ForecastResource::collection($forecasts), 'Forecasts fetched for place: ' . $place->name);

    }
}
