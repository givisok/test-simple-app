<?php

namespace App\Exceptions;

class PayGatewayException extends BaseException
{
    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'error'             => 'gateway_error',
            'error_description' => 'Payment gateway error.',
        ];
    }
}