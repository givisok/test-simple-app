<?php

namespace App\Listeners;

use App\Events\Event;
use App\Events\OrderPurchaseFail;
use App\Mail\OrderFail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderFailedNotification
{
    /**
     * @param OrderPurchaseFail $event
     */
    public function handle(OrderPurchaseFail $event)
    {
        // We can use additional queue to send from background without sending side effects
        $email = $event->order->getUserEmail();
        \Mail::to($email)/*->send(new OrderFail($event->order));*/
        ->queue(new OrderFail($event->order));
    }
}
