<?php

namespace AscentCreative\CMS\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Notification;

use AscentCreative\CMS\Notifications\WelcomeEmailNotification;

class SendWelcomeEmail
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
        Notification::send($event->user, new WelcomeEmailNotification($event->user));   

    }
}
