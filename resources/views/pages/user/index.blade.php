@extends('layouts.user')
@section('content')
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:p>{{ $title }}</x-slot:p>

    <!-- Order Statistics Cards -->
    <div class="container mx-auto">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 lg:gap-8 mb-6 md:mb-8 w-full">
            <!-- Total Orders -->
            <div
                class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-4 md:p-5 w-full h-full flex flex-col justify-between">
                <h3 class="text-gray-600 font-medium text-sm md:text-base">Total Orders</h3>
                <p class="text-2xl md:text-3xl font-bold text-gray-900">{{ $totalOrders }}</p>
                <p class="text-xs md:text-sm text-gray-500">All your orders</p>
                <div id="total_orders_chart" class="w-full min-h-[50px]"></div>
            </div>

            <!-- Pending Orders -->
            <div
                class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-4 md:p-5 w-full h-full flex flex-col justify-between">
                <h3 class="text-gray-600 font-medium text-sm md:text-base">Pending</h3>
                <p class="text-2xl md:text-3xl font-bold text-gray-900">{{ $pendingOrders }}</p>
                <p class="text-xs md:text-sm text-gray-500">Awaiting processing</p>
                <div id="pending_orders_chart" class="w-full min-h-[50px]"></div>
            </div>

            <!-- Processing Orders -->
            <div
                class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-4 md:p-5 w-full h-full flex flex-col justify-between">
                <h3 class="text-gray-600 font-medium text-sm md:text-base">Processing</h3>
                <p class="text-2xl md:text-3xl font-bold text-gray-900">{{ $processingOrders }}</p>
                <p class="text-xs md:text-sm text-gray-500">Currently in progress</p>
                <div id="processing_orders_chart" class="w-full min-h-[50px]"></div>
            </div>

            <!-- Completed Orders -->
            <div
                class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-4 md:p-5 w-full h-full flex flex-col justify-between">
                <h3 class="text-gray-600 font-medium text-sm md:text-base">Completed</h3>
                <p class="text-2xl md:text-3xl font-bold text-gray-900">{{ $completedOrders }}</p>
                <p class="text-xs md:text-sm text-gray-500">Successfully delivered</p>
                <div id="completed_orders_chart" class="w-full min-h-[50px]"></div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mb-6 md:mb-8">
        <!-- Order Status Chart -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
            <div class="p-4 md:p-5 border-b border-gray-100">
                <h3 class="text-base md:text-lg font-semibold text-gray-800">Order Status</h3>
                <p class="text-xs md:text-sm text-gray-500">Distribution of your orders</p>
            </div>
            <div class="p-4 md:p-5">
                <div id="order_status_chart" class="w-full h-64 md:h-72 lg:h-300px"></div>
            </div>
        </div>

        <!-- Recent Orders Trend -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
            <div class="p-4 md:p-5 border-b border-gray-100">
                <h3 class="text-base md:text-lg font-semibold text-gray-800">Order History</h3>
                <p class="text-xs md:text-sm text-gray-500">Your monthly ordering patterns</p>
            </div>
            <div class="p-4 md:p-5">
                <div id="order_history_chart" class="w-full h-64 md:h-72 lg:h-300px"></div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden mb-6 md:mb-8">
        <div class="p-4 md:p-5 border-b border-gray-100">
            <h3 class="text-base md:text-lg font-semibold text-gray-800">Recent Orders</h3>
            <p class="text-xs md:text-sm text-gray-500">Your latest transactions</p>
        </div>
        <div class="p-4 md:p-5">
            <div class="overflow-x-auto -mx-4 md:mx-0">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-3 md:px-6 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order Number
                            </th>
                            <th scope="col"
                                class="px-3 md:px-6 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th scope="col"
                                class="px-3 md:px-6 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount
                            </th>
                            <th scope="col"
                                class="px-3 md:px-6 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentOrders as $order)
                            <tr>
                                <td
                                    class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap text-xs md:text-sm font-medium text-gray-900">
                                    {{ $order->order_number }}
                                </td>
                                <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap text-xs md:text-sm text-gray-500">
                                    {{ $order->created_at->format('d M Y') }}
                                </td>
                                <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap text-xs md:text-sm text-gray-500">
                                    Rp. {{ number_format($order->total_amount, 2) }}
                                </td>
                                <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                                    @if ($order->status == 'completed')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Completed
                                        </span>
                                    @elseif($order->status == 'processing')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Processing
                                        </span>
                                    @elseif($order->status == 'pending')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @elseif($order->status == 'cancelled')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Cancelled
                                        </span>
                                    @else
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    class="px-3 md:px-6 py-3 md:py-4 text-center text-xs md:text-sm text-gray-500">
                                    No recent orders found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        packages: ['corechart']
    });
    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
        drawMiniCharts();
        drawOrderStatusChart();
        drawOrderHistoryChart();
    }

    function drawMiniCharts() {
        // These are placeholder mini charts - in a real implementation,
        // you would use actual order history data from your database

        // Total Orders mini chart
        var totalData = new google.visualization.DataTable();
        totalData.addColumn('number', 'X');
        totalData.addColumn('number', 'Orders');
        totalData.addRows([
            [0, 3],
            [1, 5],
            [2, 4],
            [3, 7],
            [4, 6],
            [5, 9],
            [6, {{ $totalOrders }}]
        ]);

        var totalOptions = {
            legend: 'none',
            height: 60,
            width: '100%',
            chartArea: {
                width: '100%',
                height: '100%'
            },
            lineWidth: 2,
            colors: ['#1E88E5'],
            backgroundColor: 'transparent',
            hAxis: {
                textPosition: 'none',
                gridlines: {
                    color: 'transparent'
                }
            },
            vAxis: {
                textPosition: 'none',
                gridlines: {
                    color: 'transparent'
                }
            }
        };

        var totalChart = new google.visualization.LineChart(document.getElementById('total_orders_chart'));
        totalChart.draw(totalData, totalOptions);

        // Pending Orders mini chart
        var pendingData = new google.visualization.DataTable();
        pendingData.addColumn('number', 'X');
        pendingData.addColumn('number', 'Orders');
        pendingData.addRows([
            [0, 1],
            [1, 2],
            [2, 0],
            [3, 3],
            [4, 1],
            [5, 2],
            [6, {{ $pendingOrders }}]
        ]);

        var pendingOptions = {
            legend: 'none',
            height: 60,
            width: '100%',
            chartArea: {
                width: '100%',
                height: '100%'
            },
            lineWidth: 2,
            colors: ['#FFC107'],
            backgroundColor: 'transparent',
            hAxis: {
                textPosition: 'none',
                gridlines: {
                    color: 'transparent'
                }
            },
            vAxis: {
                textPosition: 'none',
                gridlines: {
                    color: 'transparent'
                }
            }
        };

        var pendingChart = new google.visualization.LineChart(document.getElementById('pending_orders_chart'));
        pendingChart.draw(pendingData, pendingOptions);

        // Processing Orders mini chart
        var processingData = new google.visualization.DataTable();
        processingData.addColumn('number', 'X');
        processingData.addColumn('number', 'Orders');
        processingData.addRows([
            [0, 1],
            [1, 3],
            [2, 2],
            [3, 1],
            [4, 4],
            [5, 3],
            [6, {{ $processingOrders }}]
        ]);

        var processingOptions = {
            legend: 'none',
            height: 60,
            width: '100%',
            chartArea: {
                width: '100%',
                height: '100%'
            },
            lineWidth: 2,
            colors: ['#2196F3'],
            backgroundColor: 'transparent',
            hAxis: {
                textPosition: 'none',
                gridlines: {
                    color: 'transparent'
                }
            },
            vAxis: {
                textPosition: 'none',
                gridlines: {
                    color: 'transparent'
                }
            }
        };

        var processingChart = new google.visualization.LineChart(document.getElementById('processing_orders_chart'));
        processingChart.draw(processingData, processingOptions);

        // Completed Orders mini chart
        var completedData = new google.visualization.DataTable();
        completedData.addColumn('number', 'X');
        completedData.addColumn('number', 'Orders');
        completedData.addRows([
            [0, 1],
            [1, 2],
            [2, 3],
            [3, 4],
            [4, 5],
            [5, 6],
            [6, {{ $completedOrders }}]
        ]);

        var completedOptions = {
            legend: 'none',
            height: 60,
            width: '100%',
            chartArea: {
                width: '100%',
                height: '100%'
            },
            lineWidth: 2,
            colors: ['#4CAF50'],
            backgroundColor: 'transparent',
            hAxis: {
                textPosition: 'none',
                gridlines: {
                    color: 'transparent'
                }
            },
            vAxis: {
                textPosition: 'none',
                gridlines: {
                    color: 'transparent'
                }
            }
        };

        var completedChart = new google.visualization.LineChart(document.getElementById('completed_orders_chart'));
        completedChart.draw(completedData, completedOptions);
    }

    function drawOrderStatusChart() {
        var data = google.visualization.arrayToDataTable([
            ['Status', 'Count'],
            ['Pending', {{ $pendingOrders }}],
            ['Processing', {{ $processingOrders }}],
            ['Completed', {{ $completedOrders }}],
            ['Cancelled', {{ $cancelledOrders }}]
        ]);

        var options = {
            pieHole: 0.4,
            colors: ['#FFC107', '#2196F3', '#4CAF50', '#F44336'],
            chartArea: {
                width: '90%',
                height: '80%'
            },
            legend: {
                position: 'right'
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('order_status_chart'));
        chart.draw(data, options);
    }

    function drawOrderHistoryChart() {
        // This is placeholder data - in a real implementation,
        // you would fetch monthly order counts from your controller
        var data = google.visualization.arrayToDataTable([
            ['Month', 'Orders'],
            ['Jan', 3],
            ['Feb', 5],
            ['Mar', 4],
            ['Apr', 7],
            ['May', 6],
            ['Jun', 8],
            ['Jul', {{ $totalOrders }}]
        ]);

        var options = {
            legend: {
                position: 'none'
            },
            colors: ['#1E88E5'],
            chartArea: {
                width: '90%',
                height: '80%'
            },
            hAxis: {
                title: 'Month'
            },
            vAxis: {
                title: 'Number of Orders',
                minValue: 0
            }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('order_history_chart'));
        chart.draw(data, options);
    }
</script>
