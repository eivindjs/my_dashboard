<?php

namespace App\Console\Components\Fotball;

use DateTime;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Events\Fotball\DataFetched;
use GuzzleHttp\Client;  
use Football;
use Storage;


class FetchLeagueTable extends Command
{
    protected $signature = 'dashboard:fetch-league-table';

    protected $description = 'Fetch league data from a football api';


    public function handle()
    {
     
        //$league_table =  json_decode(Storage::get('league.json'));
        $league_table = Football::LeagueTable(445);
        $table = array();
        foreach($league_table->standing as $team){
            $table[] = $team;
            if($team->position === 6)
                break;
        }
        event(new DataFetched($table));
    }
}
