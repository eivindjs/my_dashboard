<?php

namespace App\Console\Components\FotballTeam;

use DateTime;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Events\FotballTeam\TeamDataFetched;
use Football;

class FetchUnitedData extends Command
{
    protected $signature = 'dashboard:fetch-united-data';

    protected $description = 'Fetch team data from football api';

    public function handle()
    {
        $year = Carbon::now()->format('Y');
        $team_data = Football::getTeamFixtures(66,$year,"n14");
        $data = array();
        foreach($team_data->fixtures as $fix){
            $data[] = $fix;
        }
        event(new TeamDataFetched($data));
    }
}
