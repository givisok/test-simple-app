<?php

namespace App\Http\Controllers\Admin\Api;


use App\Exceptions\BaseException;
use App\Exceptions\ProductMissingException;
use App\Exceptions\ProductSaveException;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Validators\ProductValidator;
use Illuminate\Http\Request;

/**
 * Class ProductsController
 *
 * @package App\Http\Controllers\Admin\Api
 */
class ProductsController extends Controller
{
    /**
     * @param Product $product
     * @return ProductResource
     */
    public function index(Product $product)
    {
        return new ProductResource($product->paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request          $request
     * @param ProductValidator $validator
     * @return ProductResource|array
     */
    public function store(Request $request, ProductValidator $validator)
    {
        try {
            $validator->passesOrFail($request->all(), $validator::RULE_CREATE);
            $product = new Product($validator->validator->valid());
            if (!$product->save()) {
                throw new ProductSaveException();
            }
        } catch (BaseException $e) {
            return $e->toArray();
        }

        return new ProductResource($product);
    }

    /**
     * @param                  $id
     * @param ProductValidator $validator
     * @return ProductResource|array
     */
    public function show($id, ProductValidator $validator)
    {
        try {
            $validator->passesOrFail(['id' => $id], $validator::RULE_FIND_BY_ID);
            $product = Product::find($id);
            if (!$product) {
                throw new ProductMissingException();
            }
        } catch (BaseException $e) {
            return $e->toArray();
        }

        return new ProductResource(Product::find($id));
    }

    /**
     * @param Request          $request
     * @param                  $id
     * @param ProductValidator $validator
     * @return ProductResource|array
     */
    public function update(Request $request, $id, ProductValidator $validator)
    {
        $input = $request->all();
        $input['id'] = $id;
        try {
            $validator->passesOrFail($input, $validator::RULE_UPDATE);
            $product = Product::find($id);
            if (!$product) {
                throw new ProductMissingException();
            }
            $product->fill($validator->validator->valid());
            if (!$product->save()) {
                throw new ProductSaveException();
            }
        } catch (BaseException $e) {
            return $e->toArray();
        }

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param                  $id
     * @param ProductValidator $validator
     * @return array
     */
    public function destroy($id, ProductValidator $validator)
    {
        try {
            $validator->passesOrFail(['id' => $id], $validator::RULE_FIND_BY_ID);
            $product = Product::find($id);
            if (!$product) {
                throw new ProductMissingException();
            }

            if (!$product->delete()) {
                throw new ProductSaveException();
            }
        } catch (BaseException $e) {
            return $e->toArray();
        }

        return ['success' => true];
    }
}