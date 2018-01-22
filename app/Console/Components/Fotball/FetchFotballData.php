
<?php

namespace App\Console\Components\Fotball;

use DateTime;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Spatie\GoogleCalendar\Event;
use App\Events\Calendar\EventsFetched;

class FetchCalendarEvents extends Command
{
    protected $signature = 'dashboard:fetch-fotball-events';

    protected $description = 'Fetch events from a Google Calendar';

    public function handle()
    {
        $url_league = "http://api.football-data.org/v1/competitions/445/leagueTable"; //Tabell
        $team_url = "http://api.football-data.org/v1/teams/66/fixtures";
        $events = collect(Event::get())
            ->map(function (Event $event) {
                $sortDate = $event->getSortDate();

                return [
                    'name' => $event->name,
                    'date' => Carbon::createFromFormat('Y-m-d H:i:s', $sortDate)->format(DateTime::ATOM),
                ];
            })
            ->unique('name')
            ->toArray();

        event(new EventsFetched($events));
    }
}
