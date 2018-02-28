<?php

namespace App\Exceptions;

class OrderAttachedSaveException extends BaseException
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
            'error_description' => 'Can\'t store order with products. Please contact with administrator.',
        ];
    }
}