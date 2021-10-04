<?php

namespace AscentCreative\CMS\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


use Spatie\Activitylog\Models\Activity;

use AscentCreative\CMS\Notifications\WelcomeEmailNotification;

class LogLogin
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
        activity()
            ->performedOn($event->user)
            ->log('login');


    }
}
