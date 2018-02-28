<?php

namespace App\Validators;

/**
 * Class OrderValidator
 *
 * @package App\Validators
 */
class ProductValidator extends BaseValidator
{
    const RULE_FIND_BY_ID = 'find_by_id';
    /**
     * @var array Validation rules
     */
    protected static $rules = [
        self::RULE_CREATE => [
            //Validate data for order modal
            'name'  => 'required|string|max:255',
            'price' => 'required|integer',
        ],

        self::RULE_FIND_BY_ID => [
            'id' => 'required|integer|min:1',
        ],

        self::RULE_UPDATE => [
            'id'    => 'required|integer|min:1',
            'name'  => 'required|string|max:255',
            'price' => 'required|integer',
        ],
    ];
}