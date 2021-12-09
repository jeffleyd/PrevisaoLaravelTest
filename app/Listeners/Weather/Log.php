<?php

namespace App\Listeners\Weather;

use App\Events\Weather\WeatherEvent;
use App\Models\WeatherLogs;

class Log
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Weather\WeatherEvent $event
     * @return void
     */
    public function handle(WeatherEvent $event)
    {
        $log = new WeatherLogs;
        $log->log = json_encode($event->data);
        $log->save();
    }
}
