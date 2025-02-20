@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
            <div class="text-center mb-8">
                <svg class="w-16 h-16 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <h1 class="text-2xl font-bold text-gray-800">Order Placed Successfully!</h1>
                <p class="text-gray-600 mt-2">Order Number: <span class="font-semibold">{{ $order->order_number }}</span>
                </p>
            </div>

            <div class="border-t border-b py-4 my-4 space-y-3">
                <div class="flex justify-between font-medium">
                    <span>Name:</span>
                    <span>{{ $order->user->name }}</span>
                </div>
                <div class="flex justify-between font-medium">
                    <span>Payment Method:</span>
                    @if ($order->payment_method === 'cop')
                    <span>Cash On Pickup</span>
                    @elseif ($order->payment_method === 'cod')
                    <span>Cash On Delivery</span>
                    @else
                    <span>Bank Transfer</span>
                    @endif
                </div>
                <div class="flex justify-between text-[1.2rem] font-bold">
                    <span>Total Amount:</span>
                    <span>Rp{{ number_format($order->total_amount) }}</span>
                </div>
            </div>

            <div class="mt-6">
                <h2 class="text-xl font-semibold mb-4">Order Items</h2>
                <div class="space-y-4">
                    @foreach ($order->items as $item)
                        <div class="flex justify-between items-center py-3 border-b last:border-b-0">
                            <div class="flex items-center space-x-4">
                                <img src="{{ asset('storage/' . $item->obat->foto) }}" alt="{{ $item->obat->nama }}"
                                    class="w-16 h-16 object-cover rounded">
                                <div>
                                    <h3 class="font-medium">{{ $item->obat->nama }}</h3>
                                    <p class="text-gray-600 text-sm">
                                        Rp{{ number_format($item->price) }} x {{ $item->quantity }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold">Rp{{ number_format($item->subtotal) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @if ($order->payment_method === 'transfer')
                <div class="mt-6 bg-blue-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-blue-800 mb-2">Payment Instructions</h3>
                    <p class="text-blue-600">Please transfer the total amount to:</p>
                    <div class="mt-2 p-3 bg-white rounded border border-blue-200">
                        <p class="font-mono">Bank: BCA</p>
                        <p class="font-mono">Account: 1234567890</p>
                        <p class="font-mono">Name: PT. Apotek Amanah</p>
                        <p class="font-mono">Amount: Rp{{ number_format($order->total_amount) }}</p>
                    </div>
                    <p class="text-sm text-blue-600 mt-2">
                        * Please include your order number ({{ $order->order_number }}) in the transfer description.
                    </p>
                </div>
            @elseif ($order->payment_method === 'cod')
                <div class="mt-6 bg-green-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-green-800 mb-2">Delivery Instructions</h3>
                    <p class="text-green-600">We will send order to your address:</p>
                    <div class="mt-2">
                        <p class="font-medium">{{ $order->user->name }}</p>
                        <p>{{ $order->shipping_address }}</p>
                        <p>Phone: {{ $order->user->phone }}</p>
                    </div>
                    <p class="text-sm text-green-600 mt-2">
                        * Don't forget to bring your order number ({{ $order->order_number }}) to our courier
                    </p>
                </div>
            @else
                <div class="mt-6 bg-green-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-green-800 mb-2">Pickup Instructions</h3>
                    <p class="text-green-600">Please pick up your order at:</p>
                    <div class="mt-2">
                        <p class="font-medium">Apotek Amanah</p>
                        <p>Jalan Ibu Apipah No. 06, Kec. Tawang, Kota Tasikmalaya</p>
                        <p>Phone: 085123456789</p>
                    </div>
                    <p class="text-sm text-green-600 mt-2">
                        * Don't forget to bring your order number ({{ $order->order_number }})
                    </p>
                </div>
            @endif

            <div class="mt-8 flex justify-center space-x-4">
                <a href="{{ route('home') }}"
                    class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <span>Back to Home</span>
                </a>
                <a href="{{ route('orders.show', $order) }}"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11M9 21V3"></path>
                    </svg>
                    <span>View Order Details</span>
                </a>
            </div>

            @if (session('success'))
                <div class="mt-6 p-4 bg-green-50 text-green-700 rounded-lg text-center">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>
@endsection
