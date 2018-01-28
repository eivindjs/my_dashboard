<?php

namespace App\Console\Components\Fotball;

use DateTime;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Events\Fotball\DataFetched;
use GuzzleHttp\Client;  

class FetchLeagueTable extends Command
{
    protected $signature = 'dashboard:fetch-league-table';

    protected $description = 'Fetch events from a Google Calendar';

    private $url_league = "http://api.football-data.org/v1/competitions/445/leagueTable";

    public function handle()
    {
        $client = new Client();
        $header = array('headers' => array('X-Auth-Token' => '44f157b0235f4a609cdc50448142c4d2'));
        $response = $client->get($this->url_league, $header);          
        $json = $response;  
        $league = array();
        foreach($json as $idx => $value){
            $league[] = $value;
            if($idx >= 6)
                break;
        }
        dump($json);
        //event(new DataFetched($events));
    }
}
