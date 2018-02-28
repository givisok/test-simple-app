<?php

namespace App\Mail;

use App\Contracts\PayableOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderFail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var PayableOrder
     */
    public $order;

    /**
     * OrderPaid constructor.
     *
     * @param PayableOrder $order
     */
    public function __construct(PayableOrder $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_SENDER'))
            ->view('emails.orders.fail')->with([
                'user_name'   => $this->order->getUserName(),
                'description' => $this->order->getDescription(),
            ]);
    }
}
