@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h2 class="text-xl font-bold">Order #{{ $order->order_number }}</h2>
        <p>Status: {{ $order->status }}</p>
        <p>Total: {{ number_format($order->total_amount, 0, ',', '.') }}</p>
    </div>
@endsection
