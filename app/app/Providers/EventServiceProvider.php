<?php

namespace App\Providers;

use App\Events\OrderPurchaseFail;
use App\Events\OrderPurchased;
use App\Listeners\OrderCompleteNotification;
use App\Listeners\OrderFailedNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        //Order was purchased
        OrderPurchased::class    => [
            OrderCompleteNotification::class,  //Send notification
        ],
        // Purchase filed :(
        OrderPurchaseFail::class => [
            OrderFailedNotification::class,  //Send fail notification
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
