<?php

namespace App\Console\Components\Yr;

use DateTime;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\ServiceProvider;
use App\Events\Yr\YrDataFetched;
use App\Models\Yr;
use Storage;

class FetchWeatherData extends Command
{
    protected $signature = 'dashboard:fetch-yr-data';

    protected $description = 'Fetch weather data from yr';

    public function handle()
    {
        $yr = new Yr;
        $yr->fylke = "Trøndelag";
        $yr->kommune = "Levanger";
        $yr->place = "Levanger";
        $yr_data = array();
        if($yr = (object)$yr->forecast_tabular[0]) {
            $yr_data['symbol'] =  Yr::getSymbol($yr->symbol['var']); //'dist/svg/'.strval($time->symbol['var']).'.svg';
            $yr_data['text'] = "Levanger: " . strval($yr->symbol['name']);
            $yr_data['temperature'] = strval($yr->temperature['value']);
        }
      
        event(new YrDataFetched($yr_data));
       
    }
}
