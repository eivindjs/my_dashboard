<?php

namespace App\Console\Components\Fotball;

use DateTime;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Events\Fotball\DataFetched;

class FetchLeagueTable extends Command
{
    protected $signature = 'dashboard:fetch-united-data';

    protected $description = 'Fetch events from a Google Calendar';

    private $team_url = "http://api.football-data.org/v1/teams/66/fixtures";

    public function handle()
    {
       
        
        $league_data = json_decode(file_get_contents($this->url_league));

        foreach($league_data as $l){
            dump($l);
        }

        //event(new DataFetched($events));
    }
}
