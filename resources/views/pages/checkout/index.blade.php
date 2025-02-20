@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left Column - Cart Items -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-semibold mb-4">Order Summary</h2>

                @if ($cartItems->isEmpty())
                    <p class="text-gray-500 text-center py-4">Your cart is empty</p>
                @else
                    <div class="space-y-4">
                        @foreach ($cartItems as $item)
                            <div class="flex items-center space-x-4 py-4 border-b">
                                <img src="{{ asset('storage/' . $item->obat->foto) }}" alt="{{ $item->obat->nama }}"
                                    class="w-20 h-20 object-cover rounded">
                                <div class="flex w-full justify-between">
                                    <div>
                                        <h3 class="font-medium">{{ $item->obat->nama }}</h3>
                                        <p class="text-gray-600">
                                            Rp{{ number_format($item->obat->harga) }} x {{ $item->quantity }}
                                        </p>
                                    </div>
                                    <div class="flex justify-end items-end">
                                        <p class="font-semibold">
                                            Subtotal: Rp{{ number_format($item->obat->harga * $item->quantity) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 pt-6 border-t">
                        <div class="flex justify-between items-center text-xl font-semibold">
                            <span>Total: </span>
                            <span>Rp{{ number_format($totalAmount) }}</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column - Checkout Form -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-semibold mb-4">Checkout Details</h2>

                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf

                    <!-- Address Selection -->
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Select Your Address
                        </label>
                        <div class="space-y-2">
                            @if (!empty(auth()->user()->address))
                                <div class="flex items-center">
                                    <input type="radio" name="address" value="{{ auth()->user()->address }}"
                                        id="savedAddress" class="mr-2" checked>
                                    <label for="savedAddress">{{ auth()->user()->address }}</label>
                                </div>
                            @endif
                            <div class="flex items-center">
                                <input type="radio" name="address" value="new" id="newAddressOption" class="mr-2">
                                <label for="newAddressOption">Add New Address</label>
                            </div>
                        </div>

                        <!-- New Address Input (Hidden by Default) -->
                        <div id="newAddressForm" class="hidden mt-3">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Enter New Address
                            </label>
                            <input type="text" name="new_address" id="newAddressInput"
                                class="w-full border rounded-lg px-3 py-2" placeholder="Enter new address">
                        </div>

                        @error('address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment Method -->
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Payment Method
                        </label>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="radio" name="payment_method" value="cop" id="cop" class="mr-2"
                                    required>
                                <label for="cop">Cash on Pickup</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" name="payment_method" value="cod" id="cod" class="mr-2"
                                    required>
                                <label for="cod">Cash on Delivery</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" name="payment_method" value="transfer" id="transfer" class="mr-2"
                                    required>
                                <label for="transfer">Bank Transfer</label>
                            </div>
                        </div>
                        @error('payment_method')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Additional Notes
                        </label>
                        <textarea name="notes" class="w-full border rounded-lg px-3 py-2 h-24 resize-none"
                            placeholder="Any special instructions..."></textarea>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700">
                        Place Order
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const newAddressOption = document.getElementById("newAddressOption");
        const newAddressForm = document.getElementById("newAddressForm");
        const newAddressInput = document.getElementById("newAddressInput");

        document.querySelectorAll('input[name="address"]').forEach((radio) => {
            radio.addEventListener("change", function() {
                if (newAddressOption.checked) {
                    newAddressForm.classList.remove("hidden");
                    newAddressInput.required = true; // Wajib diisi saat dipilih
                } else {
                    newAddressForm.classList.add("hidden");
                    newAddressInput.required = false; // Tidak wajib jika tidak dipilih
                }
            });
        });
    });
</script>
