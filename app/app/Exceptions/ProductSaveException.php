<?php

namespace App\Exceptions;

class ProductSaveException extends BaseException
{
    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'error'             => 'product_save',
            'error_description' => 'Can\'t save product.',
        ];
    }
}