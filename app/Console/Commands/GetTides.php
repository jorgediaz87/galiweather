<?php

namespace App\Console\Commands;

use App\Models\Place;
use App\Models\Port;
use App\Models\ReferencePort;
use App\Models\Tide;
use App\Models\TideForecast;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

class GetTides extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:tides';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get tides for the current stored locations in DB';

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
        Log::channel('tides')->info('Assigning the ports and reference ports to the list of locations stored in the database...');
        $places = Place::all();
        foreach ($places as $place) {
            $request = Http::get(env('API_URL') . 'getTidesInfo?coords=' . $place->latitude . ',' . $place->longitude . '&format=application/json&tz=UTC&API_KEY=' . env('API_KEY'));
            $response = $request->json();
            if (!$place->port_id && !$place->reference_port_id) {
                Log::channel('tides')->info('Assinging port and reference port to ' . $place->name);
                $portsInfo = $response['features'][0]['properties'];
                $port = Port::where('identifier', '=', $portsInfo['port']['id'])->first();
                $place->port_id = $port->id ?? null;
                $referencePort = ReferencePort::where('identifier', '=', $portsInfo['referencePort']['id'])->first();
                $place->reference_port_id = $referencePort->id;
                $place->save();
            }

            $days = $response['features'][0]['properties']['days'];
            Log::channel('tides')->info('Storing a new tide forecast for '. count($days) .' days for the location ' . $place->name . '...');
            foreach ($days as $day) {
                $tideForecast = new TideForecast();
                $tideForecast->place_id = $place->id;
                $tideForecast->begin_at = Carbon::parse($day['timePeriod']['begin']['timeInstant'])->setTimezone('UTC')->format('Y-m-d H:i:s');
                $tideForecast->end_at =Carbon::parse($day['timePeriod']['end']['timeInstant'])->setTimezone('UTC')->format('Y-m-d H:i:s');
                $tideForecast->save();
                Log::channel('tides')->info('Stored a new tide forecast for the period between '. $tideForecast->begin_at .' and ' . $tideForecast->end_at . '...');

                Log::channel('tides')->info('Creating a new tide for the location ' . $place->name . ' and the tide forecast ' .  $tideForecast->id . '...');
                foreach ($day['variables'][0]['summary'] as $summary) {
                    $tide = new Tide();
                    $tide->time_instant = Carbon::parse($summary['timeInstant'])->setTimezone('UTC')->format('Y-m-d H:i:s');
                    $tide->state = $summary['state'];
                    $tide->height = $summary['height'];
                    $tide->tide_forecast_id = $tideForecast->id;
                    $tide->save();
                }
            }
        }
        $this->info('All Done!');
    }
}
