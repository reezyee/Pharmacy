@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-wrap gap-3">
            <!-- Left Column - Resep Items -->
            <div class="bg-white w-full md:w-[68.9%] rounded-lg shadow p-6">
                <h2 class="text-2xl font-semibold mb-4">Order Summary</h2>

                @if ($resep->obatReseps->isEmpty())
                    <p class="text-gray-500 text-center py-4">There isn't a medicine in the recipe</p>
                @else
                    <div class="space-y-4">
                        @foreach ($resep->obatReseps as $item)
                            <div class="flex items-center space-x-4 py-4 border-b">
                                <img src="{{ asset('storage/' . optional($item->obat)->foto) }}"
                                    alt="{{ optional($item->obat)->nama ?? 'Medicine is not found' }}"
                                    class="w-20 h-20 object-cover rounded">
                                <div class="flex w-full justify-between">
                                    <div>
                                        <h3 class="font-medium">{{ optional($item->obat)->nama }}</h3>
                                        <p class="text-gray-600">
                                            Rp{{ number_format(optional($item->obat)->harga ?? 0) }} x {{ $item->dosis }}
                                        </p>
                                    </div>
                                    <div class="flex justify-end items-end">
                                        <p class="font-semibold">
                                            Subtotal:
                                            Rp{{ number_format((optional($item->obat)->harga ?? 0) * (int) preg_replace('/\D/', '', $item->dosis)) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 pt-6 border-t">
                        <div class="flex justify-between items-center text-xl font-semibold">
                            <span>Total Items:</span>
                            <span id="totalAmount">Rp{{ number_format($totalAmount) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-gray-700 mt-2">
                            <span>Shipping Cost:</span>
                            <span id="shippingCost">
                                @if ($totalAmount >= 100000)
                                    <span class="line-through text-gray-500">Rp10.000</span>
                                @else
                                    Rp10.000
                                @endif
                            </span>
                        </div>
                        @if ($totalAmount >= 100000)
                            <p class="text-success">🎉 Congrats! You get a free shipping cost.</p>
                        @else
                            <p class="text-danger">
                                Shop Rp{{ number_format(100000 - $totalAmount, 0, ',', '.') }} more to get free shipping
                                cost.
                            </p>
                        @endif
                        <div class="flex justify-between items-center text-gray-700 mt-2">
                            <span>Handling Fee (COD):</span>
                            <span id="handlingFee">Rp0</span>
                        </div>
                        <div class="flex justify-between items-center text-xl font-semibold mt-4 border-t pt-2">
                            <span>Grand Total:</span>
                            <span id="grandTotal">
                                @if ($totalAmount >= 100000)
                                    Rp{{ number_format($totalAmount) }}
                                @else
                                    Rp{{ number_format($totalAmount + 10000) }}
                                @endif
                            </span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column - Checkout Form -->
            <div class="bg-white w-full md:w-[30%] rounded-lg shadow p-6">
                <h2 class="text-2xl font-semibold mb-4">Checkout Details</h2>

                <form id="checkoutForm" action="{{ route('checkout.resep.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="resep_id" value="{{ $resep->id }}">

                    <!-- Payment Method -->
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Payment Method</label>
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
                    </div>

                    <!-- Address Selection -->
                    <div class="mb-6" id="addressSection">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Shipping Address
                        </label>
                        <div class="space-y-2">
                            @if ($address)
                                <div class="flex items-center">
                                    <input type="radio" name="address" value="{{ $address }}" id="savedAddress"
                                        class="mr-2" checked>
                                    <label for="savedAddress">{{ $address }}</label>
                                </div>
                            @endif
                            <div class="flex items-center">
                                <input type="radio" name="address" value="new" id="newAddressOption" class="mr-2"
                                    {{ !$address ? 'checked' : '' }}>
                                <label for="newAddressOption">Use New Address</label>
                            </div>
                        </div>

                        <div id="newAddressForm" class="{{ $address ? 'hidden' : '' }} mt-3">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Enter New Address
                            </label>
                            <textarea name="new_address" id="newAddressInput" class="w-full border rounded-lg px-3 py-2 h-24"
                                placeholder="Enter complete address..."></textarea>
                        </div>

                        @error('address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        @error('new_address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Additional Notes
                        </label>
                        <textarea name="notes" class="w-full border rounded-lg px-3 py-2 h-24 resize-none"
                            placeholder="Any special instructions...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" id="placeOrderBtn"
                        class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition duration-200">
                        Place Order
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const newAddressOption = document.getElementById("newAddressOption");
            const newAddressForm = document.getElementById("newAddressForm");
            const newAddressInput = document.getElementById("newAddressInput");
            const copRadio = document.getElementById("cop");
            const codRadio = document.getElementById("cod");
            const transferRadio = document.getElementById("transfer");
            const addressSection = document.getElementById("addressSection");
            const shippingCost = document.getElementById("shippingCost");
            const handlingFee = document.getElementById("handlingFee");
            const totalAmount = parseInt("{{ $totalAmount }}");
            const grandTotal = document.getElementById("grandTotal");
            const checkoutForm = document.getElementById("checkoutForm");
            const placeOrderBtn = document.getElementById("placeOrderBtn");

            function updateTotals() {
                let totalAmount = parseInt(document.getElementById('totalAmount').textContent.replace(/[^\d]/g,
                    '')) || 0;
                let shipping = totalAmount >= 100000 ? 0 : 10000;
                let handling = codRadio.checked ? 1000 : 0;

                shippingCost.textContent = `Rp${shipping.toLocaleString('id-ID')}`;
                handlingFee.textContent = `Rp${handling.toLocaleString('id-ID')}`;
                grandTotal.textContent = `Rp${(totalAmount + shipping + handling).toLocaleString('id-ID')}`;
            }

            document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
                radio.addEventListener("change", updateTotals);
            });

            
            // Payment method change handler
            document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
                radio.addEventListener("change", function() {
                    addressSection.style.display = copRadio.checked ? "none" : "block";
                    updateTotals();
                    
                    // Reset address validation when switching to COP
                    if (copRadio.checked) {
                        newAddressInput.setCustomValidity('');
                    }
                });
            });

            // Address selection handler
            document.querySelectorAll('input[name="address"]').forEach(radio => {
                radio.addEventListener("change", function() {
                    const isUsingNewAddress = newAddressOption.checked;
                    newAddressForm.classList.toggle("hidden", !isUsingNewAddress);

                    // Atur required hanya jika alamat baru dipilih
                    newAddressInput.required = isUsingNewAddress;

                    if (isUsingNewAddress) {
                        newAddressInput.focus();
                    } else {
                        newAddressInput.value = ''; // Reset input jika tidak dipilih
                        newAddressInput.setCustomValidity(''); // Hapus error jika ada
                    }
                });
            });


            // Form submission handler
            checkoutForm.addEventListener("submit", async function(e) {
                e.preventDefault();
                
                // Basic validation
                if (!document.querySelector('input[name="payment_method"]:checked')) {
                    alert('Please select a payment method');
                    return;
                }

                // Address validation for non-COP orders
                if (newAddressOption.checked && !newAddressInput.value.trim()) {
                    alert('Please enter your shipping address');
                    newAddressInput.focus();
                    e.preventDefault(); // Cegah form terkirim jika alamat tidak valid
                }

                // Disable button to prevent double submission
                placeOrderBtn.disabled = true;
                placeOrderBtn.innerHTML = 'Processing...';

                try {
                    const formData = new FormData(checkoutForm);
                    const response = await fetch(checkoutForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const result = await response.json();

                    if (result.success) {
                        window.location.href = result.redirect;
                    } else {
                        throw new Error(result.message || 'Failed to process order');
                    }
                } catch (error) {
                    alert(error.message || 'An error occurred. Please try again.');
                    placeOrderBtn.disabled = false;
                    placeOrderBtn.innerHTML = 'Place Order';
                }
            });

            // Input validation
            newAddressInput.addEventListener("input", function() {
                if (newAddressOption.checked && !copRadio.checked) {
                    if (this.value.trim().length < 10) {
                        this.setCustomValidity('Address must be at least 10 characters long');
                    } else {
                        this.setCustomValidity('');
                    }
                }
            });

            // Initialize totals
            updateTotals();
            
            // Initialize address form visibility
            if (newAddressOption.checked) {
                newAddressForm.classList.remove('hidden');
                newAddressInput.required = true;
            }
        });
    </script>
@endsection
