<?php

namespace App\Services;

use App\Contracts\PayableOrder;
use App\Contracts\PaySystemGateway;
use App\Events\OrderPurchased;
use App\Events\OrderPurchaseFail;
use App\Exceptions\OrderAttachedSaveException;
use App\Exceptions\OrderSaveException;
use App\Exceptions\OrderSaveStatusException;
use App\Exceptions\PayGatewayException;
use App\Exceptions\ProductMissingException;
use App\Models\Order;
use App\Models\Product;
use App\Validators\OrderValidator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class OrderService
 *
 * @package App\Services\Payments
 */
class OrderService
{
    /**
     * @var OrderValidator
     */
    private $validator;

    /**
     * OrderService constructor.
     *
     * @param OrderValidator $validator
     */
    public function __construct(OrderValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param array            $input
     * @param PaySystemGateway $gateway
     * @return PayableOrder
     * @throws \App\Exceptions\OrderSaveStatusException
     * @throws \App\Exceptions\ValidatorException
     * @throws \Exception
     */
    public function purchaseOrderOrFail(array $input, PaySystemGateway $gateway): PayableOrder
    {
        $this->validator->passesOrFail($input, OrderValidator::RULE_CREATE);
        $productsQty = array_column($input['products'], 'quantity', 'id');
        $products = $this->getProductsOrFail(array_keys($productsQty));
        try {
            $order = $this->createOrderOrFail($input, $products, $productsQty);
            $gateway->checkoutOrFail($order);
            $order->setPaymentStatusOrFail(PayableOrder::STATUS_PAID);
        } catch (OrderSaveStatusException | PayGatewayException $e) {
            // Order exist :)
            event(new OrderPurchaseFail($order));
            throw $e;
        }// here we can add additional event to send letter without order


        event(new OrderPurchased($order));

        return $order;
    }

    /**
     * Get products by ids list or fail
     *
     * @param array $ids
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    private function getProductsOrFail(array $ids): Collection
    {
        $products = Product::findMany($ids);
        $count = count($ids);
        if ($products->count() !== $count) {
            throw new ProductMissingException();
        }

        return $products;
    }

    /**
     * @param array $input
     * @param       $products
     * @param       $productsQty
     * @return Order
     * @throws \Exception
     */
    private function createOrderOrFail(array $input, $products, $productsQty): Order
    {
        \DB::beginTransaction();
        try {
            $order = new Order($input['order']);
            $order->payment_status = $order::STATUS_CREATED;
            if (!$order->save()) {
                throw new OrderSaveException();
            }

            foreach ($products as $product) {
                $order->addProduct($product, $productsQty[$product->id]);
            }
            if (!$order->save()) {
                throw new OrderAttachedSaveException();
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        return $order;
    }
}