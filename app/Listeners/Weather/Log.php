<?php

namespace App\Listeners\Weather;

use App\Events\Weather\Weather;
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
     * @param  \App\Events\Weather\Weather $event
     * @return void
     */
    public function handle(Weather $event)
    {
        $log = new WeatherLogs;
        $log->log = json_encode($event->data);
        $log->save();
    }
}
