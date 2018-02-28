@extends('layouts.app')

@section('content')
    <div class="raw">
        <div class="col-md-12">
            <a href="/logout" class="btn btn-default pull-right">Logout</a>
        </div>
    </div>
    <h1>Orders</h1>


    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Name</th>
            <th>Address</th>
            <th>Items</th>
            <th>Grand Total</th>
            <th>Status</th>
        </tr>
        </thead>

        @foreach ($orders as $order)
            <tr>
                <td>{{$order->id}} </td>
                <td>{{$order->created_at}}</td>
                <td><a href="{{$order->user_email}}">{{$order->user_name}}</a></td>
                <td>{{$order->address}}</td>
                <td>
                    <table class="table table-condensed">
                        @foreach($order->products as $product)
                            <tr>
                                <td>{{$product->name}}</td>
                                <td>{{$product->pivot->quantity}} pcs</td>
                                <td>${{$product->pivot->fixed_price / 100}}</td>
                            </tr>
                        @endforeach
                    </table>
                </td>
                <td><strong>${{$order->getPrice() / 100}}</strong></td>
                <td>
                    @if (\App\Models\Order::STATUS_PAID == $order->payment_status)
                        <span class="label label-success">Paid</span>
                    @else
                        <span class="label label-danger">Failed</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
    {{ $orders->links() }}

@endsection