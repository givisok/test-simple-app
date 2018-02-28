<?php

namespace App\Listeners;

use App\Events\Event;
use App\Events\OrderPurchased;
use App\Mail\OrderPaid;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderCompleteNotification
{
    /**
     * @param OrderPurchased $event
     */
    public function handle(OrderPurchased $event)
    {
        $email = $event->order->getUserEmail();
        \Mail::to($email)/*->send(new OrderPaid($event->order));*/
        ->queue(new OrderPaid($event->order));
    }
}
