<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MeteoSixApiService
{

    private static $_baseURL;
    private static $_apiKey;

    //
    public function __construct()
    {
        self::$_baseURL = env('API_URL');
        self::$_apiKey = env('API_KEY');
    }

    /**
     * Get a place info for the given location name
     *
     *
     * @param string $location location name
     * @return json response
     **/
    public static function getPlaces(string $location): array
    {
        $url = self::$_baseURL . 'findPlaces?location=' . $location . '&format=application/json&API_KEY=' . self::$_apiKey;
        $response = Http::get($url);
        return $response->json();
    }

    /**
     * Get the current weather forecast for the given location
     *
     *
     * @param float $latitude latitude
     * @param float $longitude longitude
     * @return json response
     **/
    public static function getForecast(float $latitude, float $longitude): array
    {
        $url = self::$_baseURL . 'getNumericForecastInfo?coords=' . $latitude . ',' . $longitude . '&format=application/json&tz=UTC&API_KEY=' . self::$_apiKey;
        $response = Http::get($url);
        return $response->json();
    }

    /**
     * Get the current tides forecast for the given location
     *
     * @param float $latitude latitude
     * @param float $longitude longitude
     * @return json response
     **/
    public static function getTides(float $latitude, float $longitude): array
    {
        $url = self::$_baseURL . 'getTidesInfo?coords=' . $latitude . ',' . $longitude . '&format=application/json&tz=UTC&API_KEY=' . self::$_apiKey;
        $response = Http::get($url);
        return $response->json();
    }


}
