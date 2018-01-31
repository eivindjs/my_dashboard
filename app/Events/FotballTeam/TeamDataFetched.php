<?php

namespace App\Events\FotballTeam;

use App\Events\DashboardEvent;

class TeamDataFetched extends DashboardEvent
{
    /** @var array */
    public $team;

    public function __construct(array $team)
    {
        $this->team = $team;
    }
}
