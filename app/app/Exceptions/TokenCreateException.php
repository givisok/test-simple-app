<?php

namespace App\Exceptions;

class TokenCreateException extends BaseException
{
    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'error'             => 'pay_token_exception',
            'error_description' => 'Can\'t create token.',
        ];
    }
}