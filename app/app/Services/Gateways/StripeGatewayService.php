<?php

namespace App\Services\Gateways;

use App\Contracts\PayableOrder;
use App\Contracts\PaySystemGateway;
use App\Exceptions\CardException;
use App\Exceptions\PayGatewayException;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Error\ApiConnection;
use Stripe\Error\Authentication;
use Stripe\Error\Base;
use Stripe\Error\Card;
use Stripe\Error\InvalidRequest;
use Stripe\Error\RateLimit;
use Stripe\Stripe;
use Stripe\Token;

/**
 * Its just a simple stripe gateway for VISA/MASTER CARD without 3d secure
 * In real app I would use token generate by stripe js.
 * I saw checkout form in task descriptions, and in form I saw cvv input and card.
 * Class StripeGatewayService
 *
 * @package App\Services\Gateways
 */
class StripeGatewayService implements PaySystemGateway
{
    /**
     * This is only for testing simple app. We need to get type of currency in real project.
     * We can pass it in DI (by user country) or from front in params.
     */
    const PAY_CURRENCY = 'usd';

    public function __construct(string $skKey)
    {
        Stripe::setApiKey($skKey);
    }

    /**
     * @param PayableOrder $order
     * @return mixed|void
     * @throws PayGatewayException
     */
    public function checkoutOrFail(PayableOrder $order)
    {
        try {
            $customer = $this->createCustomer($order);
            $this->charge($order, $customer);
        } catch (Card | Authentication | RateLimit | ApiConnection | Base | \Exception $e) {
            throw new PayGatewayException();
        }
    }

    /**
     * @param PayableOrder $order
     * @return mixed
     */
    private function createCustomer(PayableOrder $order)
    {
        $customer = Customer::create([
            'email'  => $order->getUserEmail(),
            'source' => $order->getToken(),
        ]);

        return $customer;
    }

    /**
     * @param PayableOrder $order
     * @param              $customer
     */
    private function charge(PayableOrder $order, $customer): void
    {
        Charge::create([
            'customer'    => $customer,
            'description' => $order->getDescription(),
            'amount'      => $order->getPrice(),
            'currency'    => self::PAY_CURRENCY,
        ]);
    }
}