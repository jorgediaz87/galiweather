<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MeteoSixApiService
{

    private static $_baseURL;
    private static $_apiKey;

    //Couldn't find a way to check the status code if not tides for a location, the status code returned is 200, so I have to compare the response body
    private static $tidesException;

    public function __construct()
    {
        self::$_baseURL = env('API_URL');
        self::$_apiKey = env('API_KEY');
        self::$tidesException = [
            'exception' => [
                'code' => '217',
                'message' => 'There is no information about tides for the selected location.',
            ],
        ];
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
    public static function getTides(float $latitude, float $longitude): array|null
    {
        $url = self::$_baseURL . 'getTidesInfo?coords=' . $latitude . ',' . $longitude . '&format=application/json&tz=UTC&API_KEY=' . self::$_apiKey;
        $response = Http::get($url);

        if (self::$tidesException !== $response->json()) {
            return $response->json();
        }

        return null;
    }


}
