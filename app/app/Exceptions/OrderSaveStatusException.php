<?php

namespace App\Exceptions;

class OrderSaveStatusException extends BaseException
{
    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'error'             => 'order_status',
            'error_description' => 'Can\'t save order status.',
        ];
    }
}