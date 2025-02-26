{{-- resources/views/admin/pesanan.blade.php --}}
@extends('layouts.user')

@section('content')
    <div class="p-6 bg-gradient-to-tr from-blue-50 to-purple-50 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8 p-6 bg-white/60 backdrop-blur-md rounded-xl shadow-md border-l-4 border-purple-500">
                <h1 class="text-2xl font-medium text-gray-900">Order Management</h1>
                <p class="mt-1 text-sm text-gray-600">Manage and track all customer orders</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                @foreach (['pending' => 'amber', 'processing' => 'blue', 'completed' => 'green', 'cancelled' => 'red'] as $status => $color)
                    <div
                        class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                        <div class="bg-{{ $color }}-500 h-2 w-full"></div>
                        <div class="p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="p-2 rounded-full bg-{{ $color }}-100">
                                        <svg class="w-6 h-6 text-{{ $color }}-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-sm font-medium text-gray-500 uppercase">{{ $status }}</h2>
                                    <p class="text-2xl font-medium text-gray-900">
                                        {{ $orders->where('status', $status)->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Filters -->
            <form method="GET" action="{{ route('user.orders.obat') }}" class="bg-white rounded-lg shadow-md p-6 mb-8">
                <div class="flex flex-wrap gap-6 items-end">
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" onchange="this.form.submit()"
                            class="block w-full p-2 border-0 border-b-2 border-gray-300 focus:ring-0 focus:border-purple-500 text-gray-900 bg-transparent">
                            <option value="" {{ request('status') == '' ? 'selected' : '' }}>All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing
                            </option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                    </div>
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                        <input type="date" name="date" value="{{ request('date') }}" onchange="this.form.submit()"
                            class="block w-full p-2 border-0 border-b-2 border-gray-300 focus:ring-0 focus:border-purple-500 text-gray-900 bg-transparent">
                    </div>
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search order number or customer"
                            class="block w-full p-2 border-0 border-b-2 border-gray-300 focus:ring-0 focus:border-purple-500 text-gray-900 bg-transparent">
                    </div>
                    <div>
                        <button type="submit"
                            class="px-6 py-2 bg-purple-600 text-white rounded-full shadow-md hover:bg-purple-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 transition-all duration-300">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                        clip-rule="evenodd" />
                                </svg>
                                Filter
                            </div>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Orders Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-4 font-medium text-gray-900">Order Number</th>
                                <th class="px-6 py-4 font-medium text-gray-900">Category</th>
                                <th class="px-6 py-4 font-medium text-gray-900">Total Amount</th>
                                <th class="px-6 py-4 font-medium text-gray-900">Payment Method</th>
                                <th class="px-6 py-4 font-medium text-gray-900">Status</th>
                                <th class="px-6 py-4 font-medium text-gray-900">Created At</th>
                                <th class="px-6 py-4 font-medium text-gray-900">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr class="border-b hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $order->order_number }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($order->resep_id)
                                            <span class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-purple-500"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                Prescription
                                            </span>
                                        @else
                                            <span class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-blue-500"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                </svg>
                                                OTC Medication
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-medium">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 capitalize">
                                        @if ($order->payment_method === 'transfer')
                                            <span class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-500"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                </svg>
                                                Bank Transfer
                                            </span>
                                        @elseif ($order->payment_method === 'cod')
                                            <span class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4 mr-2 text-amber-500" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                                </svg>
                                                Cash on Delivery
                                            </span>
                                        @else
                                            <span class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-blue-500"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                                </svg>
                                                Cash on Pickup
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span @class([
                                            'px-4 py-1 rounded-full text-xs font-medium',
                                            'bg-amber-100 text-amber-800' => $order->status === 'pending',
                                            'bg-blue-100 text-blue-800' => $order->status === 'processing',
                                            'bg-green-100 text-green-800' => $order->status === 'completed',
                                            'bg-red-100 text-red-800' => $order->status === 'cancelled',
                                        ])>
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ $order->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            <button type="button" data-modal-target="orderModal-{{ $order->id }}"
                                                data-modal-toggle="orderModal-{{ $order->id }}"
                                                class="p-2 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-full transition-colors duration-200">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                            @if ($order->status === 'pending')
                                                <button type="button" onclick="confirmCancelOrder({{ $order->id }})"
                                                    class="p-2 text-red-500 hover:text-red-800 hover:bg-red-50 rounded-full transition-colors duration-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="20px"
                                                        viewBox="0 -960 960 960" width="20px" fill="currentColor">
                                                        <path
                                                            d="m336-280 144-144 144 144 56-56-144-144 144-144-56-56-144 144-144-144-56 56 144 144-144 144 56 56ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Konfirmasi Pembatalan -->
                                <div id="cancelModal"
                                    class="hidden fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 backdrop-blur-sm">
                                    <div class="bg-white rounded-lg p-6 w-96 shadow-xl">
                                        <h2 class="text-lg font-medium mb-4">Konfirmasi Pembatalan</h2>
                                        <p class="text-gray-600">Apakah Anda yakin ingin membatalkan pesanan ini?</p>
                                        <div class="flex justify-end mt-6 gap-2">
                                            <button onclick="closeModal()"
                                                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-full hover:bg-gray-300 transition-colors">Batal</button>
                                            <form id="cancelForm" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="px-4 py-2 bg-red-600 text-white rounded-full hover:bg-red-700 transition-colors">Ya,
                                                    Batalkan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Order Detail Modal -->
                                <div id="orderModal-{{ $order->id }}" tabindex="-1" aria-hidden="true"
                                    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full backdrop-blur-sm">
                                    <div class="relative w-full max-w-2xl max-h-full">
                                        <div class="relative bg-white rounded-lg shadow-xl">
                                            <div class="flex items-center justify-between p-4 border-b">
                                                <h3 class="text-xl font-medium text-gray-900">
                                                    Order #{{ $order->order_number }}
                                                </h3>
                                                <button type="button"
                                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full text-sm p-2 ml-auto inline-flex justify-center items-center"
                                                    data-modal-hide="orderModal-{{ $order->id }}">
                                                    <svg class="w-5 h-5" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="p-6 space-y-6">
                                                <div class="grid grid-cols-2 gap-6">
                                                    <div class="bg-gray-50 p-4 rounded-lg">
                                                        <h4 class="text-sm font-medium text-gray-500 mb-2">Customer Details
                                                        </h4>
                                                        <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                                                        <p class="text-sm text-gray-600 mt-2">
                                                            {{ $order->shipping_address }}</p>
                                                    </div>
                                                    <div class="bg-gray-50 p-4 rounded-lg">
                                                        <h4 class="text-sm font-medium text-gray-500 mb-2">Order Details
                                                        </h4>
                                                        <p class="font-medium text-gray-900">Total: Rp
                                                            {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                                        <p class="text-sm text-gray-600 mt-2">Shipping: Rp
                                                            {{ number_format($order->shipping_cost, 0, ',', '.') }}</p>
                                                        <p class="text-sm text-gray-600">Handling: Rp
                                                            {{ number_format($order->handling_fee, 0, ',', '.') }}</p>
                                                    </div>
                                                </div>
                                                @if ($order->notes)
                                                    <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-500">
                                                        <h4 class="text-sm font-medium text-blue-800 mb-1">Notes</h4>
                                                        <p class="text-sm text-blue-700">{{ $order->notes }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script defer>
            function confirmCancelOrder(orderId) {
                document.getElementById('cancelForm').action = `/user/pesanan/${orderId}/cancel`;
                document.getElementById('cancelModal').classList.remove('hidden');
            }

            function closeModal() {
                document.getElementById('cancelModal').classList.add('hidden');
            }
        </script>
    @endpush
@endsection