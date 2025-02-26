@extends('layouts.user')
@section('content')
    <div class="p-6 bg-gradient-to-br from-blue-100 via-purple-50 to-pink-100 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-6 backdrop-blur-md bg-white/30 p-6 rounded-xl border border-white/50 shadow-lg">
                <h1 class="text-2xl font-semibold text-gray-900">Hii, {{ Auth::user()->name }}👋</h1>
                <p class="mt-1 text-sm text-gray-700">Welcome to your dashboard!</p>
            </div>

            <!-- Ringkasan Akun -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div
                    class="backdrop-blur-md bg-white/40 p-6 rounded-xl border border-white/50 shadow-lg transition-all duration-300 hover:bg-white/60 hover:shadow-xl">
                    <h2 class="text-lg font-semibold text-gray-800">Total Orders</h2>
                    <p class="text-3xl font-bold text-blue-600">{{ $totalOrders }}</p>
                </div>
                <div
                    class="backdrop-blur-md bg-white/40 p-6 rounded-xl border border-white/50 shadow-lg transition-all duration-300 hover:bg-white/60 hover:shadow-xl">
                    <h2 class="text-lg font-semibold text-gray-800">Completed Orders</h2>
                    <p class="text-3xl font-bold text-green-600">{{ $completedOrders }}</p>
                </div>
                <div
                    class="backdrop-blur-md bg-white/40 p-6 rounded-xl border border-white/50 shadow-lg transition-all duration-300 hover:bg-white/60 hover:shadow-xl">
                    <h2 class="text-lg font-semibold text-gray-800">Cancelled Orders</h2>
                    <p class="text-3xl font-bold text-red-600">{{ $cancelledOrders }}</p>
                </div>
            </div>

            <!-- Google Charts -->
            <div class="backdrop-blur-md bg-white/40 p-6 rounded-xl border border-white/50 shadow-lg mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Statistic Orders</h2>
                <div id="orders_chart" style="width: 100%; height: 400px;"></div>
            </div>

            <!-- Aktivitas Terbaru -->
            <div class="backdrop-blur-md bg-white/40 p-6 rounded-xl border border-white/50 shadow-lg">
                <div class="mb-4">
                    <h5 class="text-lg font-semibold text-gray-800">Recent Orders</h5>
                </div>
                <div>
                    @if ($recentOrders->isEmpty())
                        <p class="text-gray-700">There isn't recent orders.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-gray-800">
                                <thead>
                                    <tr class="border-b border-white/50">
                                        <th class="p-3 text-left">Order Number</th>
                                        <th class="p-3 text-left">Order Date</th>
                                        <th class="p-3 text-left">Payment Method</th>
                                        <th class="p-3 text-left">Status</th>
                                        <th class="p-3 text-left">Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentOrders as $order)
                                        <tr class="border-b border-white/30 hover:bg-white/50 transition-all duration-200">
                                            <td class="p-3">{{ $order->order_number }}</td>
                                            <td class="p-3">{{ $order->created_at->format('d M Y') }}</td>
                                            <td class="p-3">
                                                @if ($order->payment_method == 'cod')
                                                    Cash on Delivery
                                                @elseif ($order->payment_method == 'cop')
                                                    Cash on Pickup
                                                @else
                                                    Bank Transfer
                                                @endif
                                            </td>
                                            <td class="p-3">
                                                <span
                                                    class="px-2 py-1 rounded-full text-xs font-medium
                                                    @if ($order->status == 'pending') bg-yellow-200 text-yellow-800
                                                    @elseif($order->status == 'processing') bg-blue-200 text-blue-800
                                                    @elseif($order->status == 'completed') bg-green-200 text-green-800
                                                    @elseif($order->status == 'cancelled') bg-red-200 text-red-800 @endif">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="p-3">Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script>
            google.charts.load('current', {
                packages: ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Status', 'Jumlah'],
                    ['Pending', {{ $pendingOrders }}],
                    ['Processing', {{ $processingOrders }}],
                    ['Completed', {{ $completedOrders }}],
                    ['Cancelled', {{ $cancelledOrders }}]
                ]);

                var options = {
                    title: 'Orders Status',
                    pieHole: 0.4,
                    colors: ['#facc15', '#3b82f6', '#22c55e', '#ef4444'],
                    backgroundColor: 'transparent',
                    legend: {
                        textStyle: {
                            color: '#374151'
                        }
                    },
                    titleTextStyle: {
                        color: '#374151'
                    }
                };

                var chart = new google.visualization.PieChart(document.getElementById('orders_chart'));
                chart.draw(data, options);
            }
        </script>
    @endpush
@endsection
