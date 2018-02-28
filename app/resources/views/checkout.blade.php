@extends('layouts.app')

@section('content')
    <h1>Checkout</h1>
    <checkout pbtoken="{{ config('services.stripe.key') }}"></checkout>
@endsection