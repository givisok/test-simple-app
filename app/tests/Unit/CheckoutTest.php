<?php

namespace Tests\Unit;

use App\Contracts\PayableOrder;
use App\Contracts\PaySystemGateway;
use App\Exceptions\ProductMissingException;
use App\Services\OrderService;
use App\Services\PurchaseService;
use Tests\Helpers\CheckoutTrait;
use Tests\TestCase;
use Tests\Unit\Mocks\StripeGatewayMock;

class CheckoutTest extends TestCase
{
    use StripeGatewayMock;
    use CheckoutTrait;

    /**
     * @var array
     */
    private $goodData;

    /**
     * @var array
     */
    private $badData;

    public function __construct(string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->goodData = $this->goodCheckoutData();
        $this->badData = $this->badCheckoutData();
    }

    /**
     * @throws \App\Exceptions\OrderSaveStatusException
     * @throws \App\Exceptions\ValidatorException
     * @throws \Exception
     */
    public function testSuccessCheckout()
    {
        list($orderService, $gateway) = $this->prepare();

        foreach ($this->goodData as $testData) {
            /**
             * @var OrderService $orderService
             */
            $order = $orderService->purchaseOrderOrFail($testData, $gateway);

            $this->assertDatabaseHas('orders', [
                'user_name'      => $testData['order']['user_name'],
                'payment_status' => PayableOrder::STATUS_PAID,
            ]);

            foreach ($testData['products'] as $product) {
                $this->assertDatabaseHas('notices', [
                    'order_id'    => $order->id,
                    'product_id'  => $product['id'],
                    'quantity'    => $product['quantity'],
                    'fixed_price' => $product['real_price'] * 100,
                ]);
            }
        }

        $this->assertTrue(true);
    }

    public function testProductNotFound()
    {
        $this->expectException(ProductMissingException::class);
        list($orderService, $gateway) = $this->prepare();
        $testData = $this->badData['missing_product_id'];
        $orderService->purchaseOrderOrFail($testData, $gateway);
        $this->fail('Expected Exception has not been raised.');
    }

    /**
     * @return array
     */
    private function prepare(): array
    {
        $this->passStripeRequest();
        /**
         * @var OrderService $orderService
         */
        $orderService = $this->app->make(OrderService::class);
        /**
         * @var PaySystemGateway $gateway
         */
        $gateway = $this->app->make(PaySystemGateway::class);
        return [$orderService, $gateway];
    }
}
