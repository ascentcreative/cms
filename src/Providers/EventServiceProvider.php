<?php

namespace AscentCreative\CMS\Providers;

use Illuminate\Auth\Events\Registered;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            \AscentCreative\CMS\Listeners\SendWelcomeEmail::class,
        ],
    ];
}
