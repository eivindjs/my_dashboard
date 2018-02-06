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
        $team_data = Football::getTeamFixtures(66,$year,"n21");
        $data = array();

        $dayes = array(
            Carbon::SUNDAY => 'Søn',
            Carbon::MONDAY => 'Man',
            Carbon::TUESDAY => 'Tir',
            Carbon::WEDNESDAY => 'Ons',
            Carbon::THURSDAY => 'Tor',
            Carbon::FRIDAY => 'Fri',
            Carbon::SATURDAY => 'Lør'
        );
        $id = 0;
        foreach($team_data->fixtures as $fix){
            $id++;
            $away_team = json_decode(file_get_contents($fix->_links->awayTeam->href));
            $home_team = json_decode(file_get_contents($fix->_links->homeTeam->href));
            $dt = Carbon::createFromFormat("Y-m-d H:i",Carbon::parse($fix->date)->format('Y-m-d H:i'));
            $data[] = array(
                'id' => $id,
                'date' => $dayes[$dt->dayOfWeek]  . " " . $dt->addHour()->format('d.m.Y H:i'),
                'status' => $fix->status,
                'homeTeamName' => $fix->homeTeamName,
                'homeCrestURI' => $home_team->crestUrl,
                'awayTeamName' => $fix->awayTeamName,
                'awayCrestURI' => $away_team->crestUrl,
                'result' => $fix->result,
                'odds' => $fix->odds
            );
        }
        event(new TeamDataFetched($data));
    }
}
