<?php

namespace App\Validators;

use App\Exceptions\ValidatorException;
use Validator;
use Illuminate\Validation\Validator as IlluminateValidator;

/**
 * Class BaseValidator - validator for services
 *
 * @package App\Validators
 */
abstract class BaseValidator
{
    const RULE_CREATE = 'create';
    const RULE_UPDATE = 'update';

    /**
     * @var IlluminateValidator Instance of default validator
     */
    public $validator;

    /**
     * @var array List of validation rules
     */
    protected static $rules = [];

    /**
     * @var array Messages on fail
     */
    protected static $messages = [];

    /**
     * Validate data
     *
     * @param array  $data
     * @param string $scenario
     *
     * @return bool
     */
    public function passes(array $data, string $scenario): bool
    {
        $this->validator = Validator::make($data, static::$rules[$scenario], static::$messages);

        return $this->validator->passes();
    }

    /**
     * @param array  $data
     * @param string $scenario
     *
     * @throws ValidatorException
     */
    public function passesOrFail(array $data, string $scenario)
    {
        if (!$this->passes($data, $scenario)) {
            $this->fail();
        }
    }

    /**
     * @throws ValidatorException
     */
    public function fail()
    {
        throw new ValidatorException($this->validator->errors());
    }

    /**
     * @return IlluminateValidator
     */
    public function errorsBag()
    {
        return $this->validator;
    }

    /**
     * @return string
     */
    public function firstMessage(): string
    {
        return $this->validator->messages()->first();
    }
}