<?php

namespace App\Console\Commands;

use App\Models\Place;
use App\Models\Forecast;
use App\Models\SkyState;
use App\Models\Temperature;
use App\Models\Precipitation;
use App\Models\Wind;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

class GetForecast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:forecast';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get weather forecast for the current stored locations in DB';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::channel('forecast')->info('Generating the weather forecast for the current stored locations in DB...');
        $places = Place::all();
        foreach ($places as $place) {
            $request = Http::get(env('API_URL') . 'getNumericForecastInfo?coords=' . $place->latitude . ',' . $place->longitude . '&format=application/json&tz=UTC&API_KEY=' . env('API_KEY'));
            $response = $request->json();
            $days = $response['features'][0]['properties']['days'];
            Log::channel('forecast')->info('Storing forecasts for ' . count($days) . ' days for the location ' . $place->name . '...');
            foreach ($days as $day) {
                $forecast = Forecast::create([
                    'place_id' => $place->id,
                    'begin_at' => Carbon::parse($day['timePeriod']['begin']['timeInstant'])->setTimezone('UTC')->format('Y-m-d H:i:s'),
                    'end_at' =>Carbon::parse($day['timePeriod']['end']['timeInstant'])->setTimezone('UTC')->format('Y-m-d H:i:s')
                ]);
                Log::channel('tides')->info('Stored a forecast for the period between ' . $forecast->begin_at . ' and ' . $forecast->end_at . '...');
                Log::channel('tides')->info('Creating a new wheather forecast for the location ' . $place->name . ' and the forecast ' . $forecast->id . '...');
                foreach ($day['variables'] as $property) {
                    switch ($property['name']) {
                        case 'sky_state':
                            foreach ($property['values'] as $hourlyValue) {
                                SkyState::create([
                                    'forecast_id' => $forecast->id,
                                    'time_instant' => Carbon::parse($hourlyValue['timeInstant'])->setTimezone('UTC')->format('Y-m-d H:i:s'),
                                    'model_run_at' => Carbon::parse($hourlyValue['modelRun'])->setTimezone('UTC')->format('Y-m-d H:i:s'),
                                    'value' => $hourlyValue['value'],
                                ]);
                            }
                            break;
                        case 'temperature':
                            foreach ($property['values'] as $hourlyValue) {
                                Temperature::create([
                                    'forecast_id' => $forecast->id,
                                    'time_instant' => Carbon::parse($hourlyValue['timeInstant'])->setTimezone('UTC')->format('Y-m-d H:i:s'),
                                    'model_run_at' => Carbon::parse($hourlyValue['modelRun'])->setTimezone('UTC')->format('Y-m-d H:i:s'),
                                    'value' => $hourlyValue['value'],
                                ]);
                            }
                            break;
                        case 'precipitation_amount':
                            foreach ($property['values'] as $hourlyValue) {
                                Precipitation::create([
                                    'forecast_id' => $forecast->id,
                                    'time_instant' => Carbon::parse($hourlyValue['timeInstant'])->setTimezone('UTC')->format('Y-m-d H:i:s'),
                                    'model_run_at' => Carbon::parse($hourlyValue['modelRun'])->setTimezone('UTC')->format('Y-m-d H:i:s'),
                                    'value' => $hourlyValue['value'],
                                ]);
                            }
                            break;
                        case 'wind':
                            foreach ($property['values'] as $hourlyValue) {
                                Wind::create([
                                    'forecast_id' => $forecast->id,
                                    'time_instant' => Carbon::parse($hourlyValue['timeInstant'])->setTimezone('UTC')->format('Y-m-d H:i:s'),
                                    'model_run_at' => Carbon::parse($hourlyValue['modelRun'])->setTimezone('UTC')->format('Y-m-d H:i:s'),
                                    'model_value' => $hourlyValue['moduleValue'],
                                    'direction_value' => $hourlyValue['directionValue'],
                                ]);
                            }
                            break;
                    }
                }
            }
        }
        $this->info('All Done!');
    }
}
