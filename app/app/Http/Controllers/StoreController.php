<?php

namespace App\Http\Controllers;

use App\Contracts\PaySystemGateway;
use App\Exceptions\BaseException;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * @param Product $product
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList(Product $product)
    {
        return view('index', ['products' => $product->paginate(15)]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function checkOut()
    {
        return view('checkout');
    }

    /**
     * @param Request          $request
     * @param OrderService     $orderService
     * @param PaySystemGateway $gateway
     * @return array
     */
    public function checkoutProcess(Request $request, OrderService $orderService, PaySystemGateway $gateway)
    {
        try {
            $orderService->purchaseOrderOrFail($request->all(), $gateway);
            return ['success' => true];
        } catch (BaseException $e) {
            return $e->toArray();
        } catch (\Exception $e) {
            //Don't forget it's a simple app :)
            return ['error' => 'fatal_error', 'error_description' => 'unknown'];
        }
    }
}