<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

use App\Models\Place;
use App\Models\Forecast;
use App\Models\Port;
use App\Models\ReferencePort;
use App\Models\Tide;

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
            Log::channel('tides')->info('Storing a new tide forecast for ' . count($days) . ' days for the location ' . $place->name . '...');

            foreach ($days as $day) {
                $forecast = Forecast::whereDate('begin_at', '=', Carbon::parse($day['timePeriod']['begin']['timeInstant'])->setTimezone('UTC')->format('Y-m-d'))
                    ->whereDate('end_at', '=', Carbon::parse($day['timePeriod']['end']['timeInstant'])->setTimezone('UTC')->format('Y-m-d'))
                    ->where('place_id', '=', $place->id)
                    ->firstOrFail();
                Log::channel('tides')->info('Retriving the forecast for the period between ' . $forecast->begin_at . ' and ' . $forecast->end_at . '...');
                Log::channel('tides')->info('Creating a new tide for the location ' . $place->name . ' and the forecast ' . $forecast->id . '...');
                foreach ($day['variables'][0]['summary'] as $summary) {
                    Tide::create([
                        'forecast_id' => $forecast->id,
                        'time_instant' => Carbon::parse($summary['timeInstant'])->setTimezone('UTC')->format('Y-m-d H:i:s'),
                        'state' => $summary['state'],
                        'height' => $summary['height']
                    ]);
                }
            }
        }
        $this->info('All Done!');
    }
}
