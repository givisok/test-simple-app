@extends('layouts.app')

@section('content')
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#store">Store</a></li>
        <li><a data-toggle="tab" href="#cart">Cart <span class="badge">@{{ cartCount}}</span></a></li>
    </ul>
    <div class="tab-content">
        <div id="store" class="tab-pane fade in active">
            <h1>Store</h1>
            <table class="table">
                <thead>
                <tr>
                    <th width="*">Product</th>
                    <th width="10%">Price</th>
                    <th width="10%">Qty</th>
                    <th width="20%" class="text-right">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($products as $product)
                    <tr is="product" :product="{{
                                $product->makeHidden('created_at')
                                ->makeHidden('updated_at')->makeHidden('deleted_at')->toJson()
                                }}"></tr>
                @endforeach
                </tbody>
            </table>
            {{ $products->links() }}
        </div>
        <div id="cart" class="tab-pane fade">
            <h1>Cart</h1>
            <div class="raw">
                <shop-cart></shop-cart>
            </div>
        </div>
    </div>
@endsection