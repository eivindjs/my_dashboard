<?php

namespace App\Events\Yr;

use App\Events\DashboardEvent;

class YrDataFetched extends DashboardEvent
{
    /** @var array */
    public $weather;

    public function __construct(array $weather)
    {
        $this->weather = $weather;
    }
}
