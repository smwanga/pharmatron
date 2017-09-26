<?php

namespace App\Providers;

use App\Listeners\UserEventsListener;
use Illuminate\Support\Facades\Event;
use App\Listeners\InventoryEventsSubscriber;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
    ];

    protected $subscribe = [
        InventoryEventsSubscriber::class,
        UserEventsListener::class,
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();
    }
}
