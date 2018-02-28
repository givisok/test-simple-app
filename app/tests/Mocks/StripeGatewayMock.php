<?php

namespace Tests\Unit\Mocks;

use App\Contracts\PaySystemGateway;
use App\Services\Gateways\StripeGatewayService;

/**
 * @property mixed $app
 */
trait StripeGatewayMock
{
    /**
     * Make stripe request pass
     */
    protected function passStripeRequest()
    {
        $serviceAccountMock = $this->createMock(StripeGatewayService::class);

        $serviceAccountMock->expects($this->any())
            ->method('checkoutOrFail');

        $this->createPayGatewaySingleton($serviceAccountMock);
    }

    /**
     * @param $serviceAccountMock
     */
    protected function createPayGatewaySingleton($serviceAccountMock)
    {
        $this->app->singleton(PaySystemGateway::class, function () use ($serviceAccountMock) {
            return $serviceAccountMock;
        });
    }
}