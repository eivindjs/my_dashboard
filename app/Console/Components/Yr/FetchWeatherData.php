<?php

namespace App\Console\Components\Yr;

use DateTime;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\ServiceProvider;
use App\Events\Yr\YrDataFetched;

use Storage;

class FetchWeatherData extends Command
{
    protected $signature = 'dashboard:fetch-yr-data';

    protected $description = 'Fetch weather data from yr';

    private $xml_link = "http://www.yr.no/sted/Norge/Tr%C3%B8ndelag/Levanger/Levanger/varsel_time_for_time.xml";

    public function handle()
    {
        $yr_xml = file_get_contents($this->xml_link);
        $yr_xml = new \SimpleXMLElement($yr_xml);
        $now = Carbon::now()->format('Y-m-d H:i');
        $yr_data = array();
        foreach($yr_xml->forecast->tabular->time as $time){
            $from_time = Carbon::parse($time['from'])->format('Y-m-d H:i');
            $to_time = Carbon::parse($time['to'])->format('Y-m-d H:i');
            $to_time_midnight = Carbon::parse($time['to'])->format('H:i');

            //if(($now >= $from_time) && ($now <= $to_time || $to_time == '00:00')){ //Denne må sees på kan være fra idag til og med kl 00:00 dagen etterpå
                $yr_data['symbol'] =  'dist/svg/'.strval($time->symbol['var']).'.svg';
                $yr_data['text'] = "Levanger: " . strval($time->symbol['name']);
                $yr_data['temperature'] = strval($time->temperature['value']);
            //}
            break;
        }
        
        event(new YrDataFetched($yr_data));
       
    }
}
