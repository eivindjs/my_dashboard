<?php

namespace App\Console\Components\Yr;

use DateTime;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\ServiceProvider;
use App\Events\Yr\Weather;

use Storage;

class FetchWeatherData extends Command
{
    protected $signature = 'dashboard:fetch-yr-data';

    protected $description = 'Fetch weather data from yr';

    private $xml_link = "https://www.yr.no/sted/Norge/Tr%C3%B8ndelag/Levanger/Levanger/varsel.xml";

    public function handle()
    {
        //$yr_xml = file_get_contents($this->xml_link);
        $yr_xml =  Storage::get('yr_data.xml');
        $yr_xml = new \SimpleXMLElement($yr_xml);
        $now = Carbon::now()->format('Y-m-d H:i');
        //Storage::disk('local')->put('file.xml', print_r($yr_xml,true));
        //$yr_xml = simplexml_load_string($yr_xml);
        $yr_data = collect();
        foreach($yr_xml->forecast->tabular->time as $time){
            $from_time = Carbon::parse($time['from'])->format('Y-m-d H:i');
            $to_time = Carbon::parse($time['to'])->format('Y-m-d H:i');
            if($now >= $from_time && $now <= $to_time){
                $yr_data->symbol =  $time->symbol['var'];
                $yr_data->text = $time->symbol['name'];
                $yr_data->temperature = $time->temperature['value'];
            }
        }
        event(new Weather(array('temperature' => 3)));
       
    }
}
