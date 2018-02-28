<?php

namespace App\Validators;

/**
 * Class OrderValidator
 *
 * @package App\Validators
 */
class OrderValidator extends BaseValidator
{
    //const RULE_CHECKOUT = 'checkout';
    /**
     * @var array Validation rules
     */
    protected static $rules = [
        self::RULE_CREATE => [
            //Validate data for order modal
            'order.user_name'       => 'required|string',
            'order.user_email'      => 'required|email',
            'order.address'         => 'required|string|max:255',
            'order.token'           => 'required|size:28',
            //Validate data for products modal
            'products'              => 'required|array',
            'products.*.id'         => 'required|integer|min:1',
            'products.*.quantity'   => 'required|integer|min:1',
        ],
        /*
        self::RULE_CHECKOUT => [
            'address'         => 'required|string|max:255',
            'cardNumber'      => 'required|string|creditcard',
            'cardExpireMonth' => 'required|integer|min:1|max:12',
            'cardExpireYear'  => 'required|digits:2',
            'cardCVV'         => 'required|digits:3',
            'price'           => ''
        ]*/
    ];
}