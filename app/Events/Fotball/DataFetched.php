<?php

namespace App\Events\Fotball;

use App\Events\DashboardEvent;

class DataFetched extends DashboardEvent
{
    /** @var array */
    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
