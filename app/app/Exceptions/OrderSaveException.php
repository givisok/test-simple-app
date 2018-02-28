<?php

namespace App\Exceptions;

class OrderSaveException extends BaseException
{
    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'error'             => 'store_exception',
            'error_description' => 'Can\'t store order. Please contact with administrator.',
        ];
    }
}