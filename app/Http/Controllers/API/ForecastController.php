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
        Log::channel('forecasts')->info('Forecasts fetched for place: ' . $place->name);
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
        $beginAt = $request->input('begin_at');
        $endAt = $request->input('end_at');

        $place = Place::find($placeID);
        $forecasts = ForecastService::findByDateAndPlace($place, $beginAt, $endAt);
        Log::channel('forecasts')->info('Forecasts fetched for place: ' . $place->name. ' between ' . $beginAt . ' and ' . $endAt);
        return $this->sendResponse(new ForecastResource($forecasts), 'Forecasts fetched for place: ' . $place->name);
    }
}
