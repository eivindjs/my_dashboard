<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Services\TweetHistory\TweetHistory;
use App\Models\Yr;

class DashboardController extends Controller
{
    public function index()
    {

        $yr = new Yr;
        $yr->fylke = "Trøndelag";
        $yr->kommune = "Levanger";
        $yr->place = "Levanger";

        dd($yr->forecast_tabular);
        
        return view('dashboard')->with([
            'pusherKey' => config('broadcasting.connections.pusher.key'),

            'pusherCluster' => config('broadcasting.connections.pusher.options.cluster'),

            'initialTweets' => TweetHistory::all(),

            'usingNodeServer' => usingNodeServer(),
        ]);
    }
}
