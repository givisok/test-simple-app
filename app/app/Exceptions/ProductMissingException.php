<?php

namespace App\Exceptions;

class ProductMissingException extends BaseException
{
    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'error'             => 'product_missing',
            'error_description' => 'Can\'t find product.',
        ];
    }
}