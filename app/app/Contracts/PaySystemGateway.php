<?php

namespace App\Contracts;

use App\Exceptions\PayGatewayException;

/**
 * Interface PaySystemGateway
 *
 * @property integer $id
 */
interface PaySystemGateway
{
    /**
     * @param PayableOrder $order
     * @throws PayGatewayException
     * @return mixed
     */
    public function checkoutOrFail(PayableOrder $order);
}