<?php

namespace App\Events;

use App\Contracts\PayableOrder;
use Illuminate\Queue\SerializesModels;

class OrderPurchased extends Event
{
    use SerializesModels;

    /**
     * @public PayableOrder
     */
    public $order;

    /**
     * PackWasPurchased constructor
     *
     * @param PayableOrder $order
     */
    public function __construct(PayableOrder $order)
    {
        $this->order = $order;
    }
}
