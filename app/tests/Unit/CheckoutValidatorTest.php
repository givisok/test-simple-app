<?php

namespace Tests\Unit;

use App\Exceptions\ValidatorException;
use App\Validators\OrderValidator;
use Tests\Helpers\CheckoutTrait;
use Tests\TestCase;

class CheckoutValidatorTest extends TestCase
{
    use CheckoutTrait;

    /**
     * @var mixed
     */
    private $badData;

    /**
     * CheckoutValidatorTest constructor.
     *
     * @param string|null $name
     * @param array       $data
     * @param string      $dataName
     */
    public function __construct(string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->badData = $this->badValidatorData();
    }

    /**
     * @throws ValidatorException
     */
    public function testBadCard()
    {
        $this->runWithException('bad_token');
    }

    /**
     * @throws ValidatorException
     */
    public function testEmptyProduct()
    {
        $this->runWithException('empty_product');
    }

    /**
     * @throws ValidatorException
     */
    public function testEmptyOrder()
    {
        $this->runWithException('empty_order');
    }

    /**
     * @throws ValidatorException
     */
    public function testBadProductId()
    {
        $this->runWithException('bad_product_id');
    }

    /**
     * @param string $testKey
     * @throws ValidatorException
     */
    private function runWithException(string $testKey)
    {
        $this->expectException(ValidatorException::class);
        $orderValidator = $this->app->make(OrderValidator::class);
        $data = $this->badData[$testKey];
        $orderValidator->passesOrFail($data, OrderValidator::RULE_CREATE);
        $this->fail('Expected Exception has not been raised.');
    }
}
