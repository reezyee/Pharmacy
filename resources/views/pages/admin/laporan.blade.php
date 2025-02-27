@extends('layouts.user')

@section('content')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    <div class="p-4 sm:p-6 bg-gray-50">
        <!-- Dashboard Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Laporan Penjualan</h1>
                <p class="text-gray-500">Ringkasan performa apotek dan penjualan produk</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 mt-4 md:mt-0">
                <form action="{{ route('admin.laporan') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                    <select name="bulan"
                        class="bg-white text-gray-700 border border-gray-200 focus:ring-4 focus:ring-blue-100 font-medium rounded-lg text-sm px-4 py-2.5">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                {{ Carbon\Carbon::create(null, $i, 1)->format('F') }}
                            </option>
                        @endfor
                    </select>
                    <select name="tahun"
                        class="bg-white text-gray-700 border border-gray-200 focus:ring-4 focus:ring-blue-100 font-medium rounded-lg text-sm px-4 py-2.5">
                        @for ($y = Carbon\Carbon::now()->year; $y >= Carbon\Carbon::now()->year - 5; $y--)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}
                            </option>
                        @endfor
                    </select>
                    <button type="submit"
                        class="bg-white text-gray-700 border border-gray-200 focus:ring-4 focus:ring-blue-100 font-medium rounded-lg text-sm px-4 py-2.5">
                        <span class="material-icons mr-2 text-gray-500">filter_list</span>
                        Filter
                    </button>
                </form>
                {{-- <button type="button" id="exportBtn"
                    class="flex items-center text-white bg-cyan-500 hover:bg-cyan-600 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-4 py-2.5">
                    <span class="material-icons mr-2">file_download</span>
                    Export Laporan
                </button> --}}
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Total Pendapatan Card -->
            <div
                class="bg-white border-l-4 border-cyan-500 rounded-lg shadow-sm hover:shadow-md transition-shadow p-5 relative">
                <div
                    class="absolute top-5 right-5 flex items-center justify-center w-12 h-12 rounded-full bg-cyan-50 text-cyan-500">
                    <span class="material-icons">payments</span>
                </div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Total Pendapatan</h3>
                <div class="text-2xl font-semibold text-gray-800 mb-2">Rp
                    {{ number_format($penjualan->sum('subtotal'), 0, ',', '.') }}
                </div>
                <div class="flex items-center text-emerald-600 text-sm">
                    <span class="material-icons mr-1 text-base">trending_up</span>
                    <span>8.2% dari bulan lalu</span>
                </div>
            </div>

            <!-- Total Resep Card -->
            <div
                class="bg-white border-l-4 border-lime-500 rounded-lg shadow-sm hover:shadow-md transition-shadow p-5 relative">
                <div
                    class="absolute top-5 right-5 flex items-center justify-center w-12 h-12 rounded-full bg-lime-50 text-lime-500">
                    <span class="material-icons">medical_services</span>
                </div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Total Resep Ditebus</h3>
                <div class="text-2xl font-semibold text-gray-800 mb-2">{{ $penjualan->where('is_resep', 1)->count() }}</div>
                <div class="flex items-center text-emerald-600 text-sm">
                    <span class="material-icons mr-1 text-base">trending_up</span>
                    <span>5.3% dari bulan lalu</span>
                </div>
            </div>

            <!-- Rata-rata Transaksi Card -->
            <div
                class="bg-white border-l-4 border-cyan-500 rounded-lg shadow-sm hover:shadow-md transition-shadow p-5 relative">
                <div
                    class="absolute top-5 right-5 flex items-center justify-center w-12 h-12 rounded-full bg-cyan-50 text-cyan-500">
                    <span class="material-icons">local_pharmacy</span>
                </div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Rata-rata Transaksi</h3>
                <div class="text-2xl font-semibold text-gray-800 mb-2">Rp
                    {{ number_format($penjualan->count() > 0 ? $penjualan->sum('subtotal') / $penjualan->count() : 0, 0, ',', '.') }}
                </div>
                <div class="flex items-center text-emerald-600 text-sm">
                    <span class="material-icons mr-1 text-base">trending_up</span>
                    <span>3.1% dari bulan lalu</span>
                </div>
            </div>

            <!-- Stok Hampir Habis Card -->
            <div
                class="bg-white border-l-4 border-lime-500 rounded-lg shadow-sm hover:shadow-md transition-shadow p-5 relative">
                <div
                    class="absolute top-5 right-5 flex items-center justify-center w-12 h-12 rounded-full bg-lime-50 text-lime-500">
                    <span class="material-icons">inventory</span>
                    <span
                        class="absolute -top-1 -right-1 flex items-center justify-center w-5 h-5 bg-red-500 text-white text-xs rounded-full">{{ $stokHampirHabis }}</span>
                </div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Stok Hampir Habis</h3>
                <div class="text-2xl font-semibold text-gray-800 mb-2">{{ $stokHampirHabis }} Obat</div>
                <div class="flex items-center text-red-600 text-sm">
                    <span class="material-icons mr-1 text-base">priority_high</span>
                    <span>Perlu pemesanan segera</span>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="mb-6">
            <div class="text-sm font-medium text-center border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px">
                    <li class="mr-2">
                        <a href="#"
                            class="inline-block p-4 text-cyan-600 border-b-2 border-cyan-600 rounded-t-lg active"
                            aria-current="page">Semua Penjualan</a>
                    </li>
                    <li class="mr-2">
                        <a href="#"
                            class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300">Resep</a>
                    </li>
                    <li class="mr-2">
                        <a href="#"
                            class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300">Non-Resep</a>
                    </li>
                    <li>
                        <a href="#"
                            class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300">Kategori</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Sales Trend Chart -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Tren Penjualan</h3>
                    <div class="inline-flex rounded-md shadow-sm" role="group">
                        <button type="button"
                            class="px-4 py-2 text-sm font-medium text-cyan-600 bg-white border border-gray-200 rounded-l-lg hover:bg-gray-100 hover:text-cyan-700 focus:z-10 focus:ring-2 focus:ring-cyan-200">
                            Mingguan
                        </button>
                        <button type="button"
                            class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-r border-gray-200 rounded-r-lg hover:bg-gray-100 hover:text-cyan-700 focus:z-10 focus:ring-2 focus:ring-cyan-200">
                            Bulanan
                        </button>
                    </div>
                </div>
                <div id="salesTrendChart" class="h-72"></div>
            </div>

            <!-- Sales Distribution Chart -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Distribusi Penjualan</h3>
                    <div class="inline-flex rounded-md shadow-sm" role="group">
                        <button type="button"
                            class="px-4 py-2 text-sm font-medium text-cyan-600 bg-white border border-gray-200 rounded-l-lg hover:bg-gray-100 hover:text-cyan-700 focus:z-10 focus:ring-2 focus:ring-cyan-200">
                            Kategori
                        </button>
                        <button type="button"
                            class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-r border-gray-200 rounded-r-lg hover:bg-gray-100 hover:text-cyan-700 focus:z-10 focus:ring-2 focus:ring-cyan-200">
                            Produsen
                        </button>
                    </div>
                </div>
                <div id="salesDistributionChart" class="h-72"></div>
            </div>
        </div>

        <!-- Top Products & Low Stock Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Top Products Section -->
            <div class="bg-white rounded-lg shadow-sm p-6 lg:col-span-2">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Produk Terlaris</h3>
                <div class="space-y-4">
                    @php
                        $topProducts = $penjualan
                            ->groupBy('obat_id')
                            ->map(function ($items) {
                                return [
                                    'total' => $items->sum('quantity'),
                                    'obat' => $items->first()->obat ?? null,
                                ];
                            })
                            ->sortByDesc('total')
                            ->take(5);

                        $maxSales = $topProducts->isEmpty() ? 1 : $topProducts->first()['total'];
                    @endphp

                    @foreach ($topProducts as $index => $product)
                        @if ($product['obat'])
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-8 font-semibold text-lime-500 text-xl text-center mr-3">
                                    {{ $index + 1 }}</div>
                                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-gray-100 mr-3">
                                    <span class="material-icons text-gray-600">medication</span>
                                </div>
                                <div class="flex-1 mr-4">
                                    <div class="flex justify-between mb-1">
                                        <span class="font-medium text-gray-800">{{ $product['obat']->nama }}</span>
                                        <span class="text-gray-500 text-sm">{{ $product['total'] }} unit terjual</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                                        <div class="bg-cyan-500 h-1.5 rounded-full"
                                            style="width: {{ ($product['total'] / $maxSales) * 100 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    @if ($topProducts->isEmpty())
                        <div class="text-center py-4 text-gray-500">
                            Tidak ada data penjualan untuk periode ini
                        </div>
                    @endif
                </div>
            </div>

            <!-- Low Stock Section -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Stok Hampir Habis</h3>
                <div id="lowStockChart" class="h-56"></div>
                <div class="mt-6">
                    <a href="{{ url('/admin/obat') }}">
                        <button type="button"
                            class="w-full flex items-center justify-center text-white bg-cyan-500 hover:bg-cyan-600 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5">
                            <span class="material-icons mr-2">add_shopping_cart</span>
                            Buat Pesanan Stok
                        </button>
                    </a>
                </div>
            </div>
        </div>

        <!-- Revenue & Performance Metrics -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Monthly Revenue Chart -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Pendapatan per Bulan</h3>
                <div id="monthlyRevenueChart" class="h-72"></div>
            </div>

            <!-- Daily Performance Chart -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Performa Harian</h3>
                <div id="dailyPerformanceChart" class="h-72"></div>
            </div>
        </div>

        <!-- Latest Transactions Table -->
        <div class="bg-white shadow-sm rounded-lg mb-6 overflow-hidden">
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-center p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-3 md:mb-0">Detail Transaksi Terbaru</h3>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <span class="material-icons text-gray-400">search</span>
                    </div>
                    <input type="text" id="search-transactions"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full pl-10 p-2.5"
                        placeholder="Cari transaksi...">
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Produk</th>
                            <th scope="col" class="px-6 py-3">Kuantitas</th>
                            <th scope="col" class="px-6 py-3">Harga</th>
                            <th scope="col" class="px-6 py-3">Subtotal</th>
                            <th scope="col" class="px-6 py-3">Tanggal</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penjualan->take(10) as $item)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="flex items-center justify-center w-10 h-10 rounded-lg bg-gray-100 mr-3">
                                            <span class="material-icons text-gray-600">medication</span>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">
                                                {{ $item->obat->nama ?? 'Tidak Diketahui' }}</div>
                                            <div class="text-xs text-gray-500">
                                                {{ $item->obat->kategori->nama ?? 'Tidak Diketahui' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">{{ $item->quantity }} unit</td>
                                <td class="px-6 py-4">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">{{ $item->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">Selesai</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    Tidak ada transaksi untuk periode ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav class="flex justify-center p-4" aria-label="Table navigation">
                <ul class="inline-flex -space-x-px text-sm">
                    <li>
                        <a href="#"
                            class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700">
                            <span class="material-icons text-sm">chevron_left</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-cyan-600 bg-cyan-50 border border-gray-300 hover:bg-cyan-100 hover:text-cyan-700">1</a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">2</a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">3</a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700">
                            <span class="material-icons text-sm">chevron_right</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Load Google Charts
            google.charts.load('current', {
                packages: ['corechart', 'bar', 'line', 'gauge']
            });

            google.charts.setOnLoadCallback(initCharts);

            function initCharts() {
                // Small delay to ensure DOM elements are ready
                setTimeout(drawAllCharts, 100);
            }

            function drawAllCharts() {
                drawSalesTrendChart();
                drawSalesDistributionChart();
                drawLowStockChart();
                drawMonthlyRevenueChart();
                drawDailyPerformanceChart();
            }

            function drawSalesTrendChart() {
                // Data preparation based on actual database data
                var data = google.visualization.arrayToDataTable([
                    ['Minggu', 'Pendapatan', 'Target'],
                    @php
                        // Prepare weekly data
                        $weeklyData = [];
                        foreach ($weeklySales as $week) {
                            $weekNumber = $week->minggu;
                            $total = $week->total;
                            // Simple target calculation based on past performance plus 10%
                            $target = $total * 0.9; // Assuming target is 90% of what was achieved
                            $weeklyData[] = "['Minggu {$weekNumber}', {$total}, {$target}]";
                        }

                        // If no data, provide sample data
                        if (empty($weeklyData)) {
                            echo "['Minggu 1', 15000000, 14000000],";
                            echo "['Minggu 2', 18000000, 16000000],";
                            echo "['Minggu 3', 24000000, 20000000],";
                            echo "['Minggu 4', 23000000, 22000000]";
                        } else {
                            echo implode(',', $weeklyData);
                        }
                    @endphp
                ]);

                var options = {
                    colors: ['#0891b2', '#bef264'],
                    chartArea: {
                        width: '85%',
                        height: '75%'
                    },
                    legend: {
                        position: 'top'
                    },
                    hAxis: {
                        textStyle: {
                            color: '#64748b',
                            fontSize: 12
                        }
                    },
                    vAxis: {
                        textStyle: {
                            color: '#64748b',
                            fontSize: 12
                        },
                        format: 'Rp#,###',
                        minValue: 0,
                        gridlines: {
                            color: '#f1f5f9',
                            count: 5
                        }
                    },
                    pointSize: 6,
                    curveType: 'function',
                    animation: {
                        startup: true,
                        duration: 1000,
                        easing: 'out'
                    }
                };

                var chart = new google.visualization.LineChart(document.getElementById('salesTrendChart'));
                chart.draw(data, options);
            }

            function drawSalesDistributionChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Kategori', 'Penjualan'],
                    @php
                        // Prepare category data
                        $categoryData = [];
                        foreach ($salesByCategory as $category) {
                            $name = $category->kategori ? $category->kategori->nama : 'Tidak Dikategorikan';
                            $total = $category->total;
                            $categoryData[] = "['{$name}', {$total}]";
                        }

                        // If no data, provide sample data
                        if (empty($categoryData)) {
                            echo "['Antibiotik', 25],";
                            echo "['Vitamin', 35],";
                            echo "['Analgesik', 15],";
                            echo "['Antipiretik', 10],";
                            echo "['Lainnya', 15]";
                        } else {
                            echo implode(',', $categoryData);
                        }
                    @endphp
                ]);

                var options = {
                    colors: ['#0891b2', '#bef264', '#38bdf8', '#4ade80', '#fbbf24'],
                    pieHole: 0.4,
                    chartArea: {
                        width: '90%',
                        height: '85%'
                    },
                    legend: {
                        position: 'right',
                        textStyle: {
                            color: '#64748b',
                            fontSize: 12
                        }
                    },
                    pieSliceText: 'percentage',
                    sliceVisibilityThreshold: 0.05,
                    animation: {
                        startup: true,
                        duration: 1000,
                        easing: 'out'
                    }
                };

                var chart = new google.visualization.PieChart(document.getElementById('salesDistributionChart'));
                chart.draw(data, options);
            }

            function drawLowStockChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Label', 'Value'],
                    ['Stok Kritikal', {{ $stokHampirHabis }}]
                ]);

                var options = {
                    redFrom: 8,
                    redTo: 10,
                    yellowFrom: 4,
                    yellowTo: 8,
                    greenFrom: 0,
                    greenTo: 4,
                    minorTicks: 5,
                    min: 0,
                    max: 10,
                    animation: {
                        duration: 1000,
                        easing: 'out'
                    }
                };

                var chart = new google.visualization.Gauge(document.getElementById('lowStockChart'));
                chart.draw(data, options);
            }

            function drawMonthlyRevenueChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Bulan', 'Pendapatan', 'Target'],
                    @php
                        // Prepare monthly data
                        $monthlyData = [];
                        foreach ($monthlySales as $month) {
                            $monthName = Carbon\Carbon::create(null, $month->bulan, 1)->format('M');
                            $total = $month->total;
                            // Simple target calculation
                            $target = $total * 0.95;
                            $monthlyData[] = "['{$monthName}', {$total}, {$target}]";
                        }

                        // If no data, provide sample data
                        if (empty($monthlyData)) {
                            echo "['Jan', 50000000, 48000000],";
                            echo "['Feb', 60000000, 55000000],";
                            echo "['Mar', 55000000, 60000000],";
                            echo "['Apr', 65000000, 62000000],";
                            echo "['Mei', 80000000, 70000000],";
                            echo "['Jun', 75000000, 75000000]";
                        } else {
                            echo implode(',', $monthlyData);
                        }
                    @endphp
                ]);

                var options = {
                    colors: ['#0891b2', '#bef264'],
                    chartArea: {
                        width: '85%',
                        height: '75%'
                    },
                    legend: {
                        position: 'top'
                    },
                    hAxis: {
                        textStyle: {
                            color: '#64748b',
                            fontSize: 12
                        }
                    },
                    vAxis: {
                        textStyle: {
                            color: '#64748b',
                            fontSize: 12
                        },
                        format: 'Rp#,###',
                        minValue: 0,
                        gridlines: {
                            color: '#f1f5f9',
                            count: 5
                        }
                    },
                    animation: {
                        startup: true,
                        duration: 1000,
                        easing: 'out'
                    }
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('monthlyRevenueChart'));
                chart.draw(data, options);
            }

            function drawDailyPerformanceChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Hari', 'Jumlah Transaksi'],
                    @php
                        // Map day numbers to day names
                        $dayNames = [
                            0 => 'Minggu',
                            1 => 'Senin',
                            2 => 'Selasa',
                            3 => 'Rabu',
                            4 => 'Kamis',
                            5 => 'Jumat',
                            6 => 'Sabtu',
                        ];

                        // Prepare daily transaction data
                        $dailyData = [];
                        foreach ($dailySales as $day) {
                            $dayName = $dayNames[$day->hari] ?? 'Tidak Diketahui';
                            $transactions = $day->transaksi;
                            $dailyData[] = "['{$dayName}', {$transactions}]";
                        }

                        // If no data, provide sample data
                        if (empty($dailyData)) {
                            echo "['Senin', 42],";
                            echo "['Selasa', 38],";
                            echo "['Rabu', 54],";
                            echo "['Kamis', 57],";
                            echo "['Jumat', 63],";
                            echo "['Sabtu', 82],";
                            echo "['Minggu', 45]";
                        } else {
                            echo implode(',', $dailyData);
                        }
                    @endphp
                ]);

                var options = {
                    colors: ['#0891b2'],
                    chartArea: {
                        width: '85%',
                        height: '75%'
                    },
                    legend: {
                        position: 'none'
                    },
                    hAxis: {
                        textStyle: {
                            color: '#64748b',
                            fontSize: 12
                        }
                    },
                    vAxis: {
                        textStyle: {
                            color: '#64748b',
                            fontSize: 12
                        },
                        minValue: 0,
                        gridlines: {
                            color: '#f1f5f9',
                            count: 5
                        }
                    },
                    bar: {
                        groupWidth: '60%'
                    },
                    animation: {
                        startup: true,
                        duration: 1000,
                        easing: 'out'
                    }
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('dailyPerformanceChart'));
                chart.draw(data, options);
            }

            // Handle Export Report Button Click
  /

            // Add window resize listener to redraw charts when window size changes
            window.addEventListener('resize', drawAllCharts);
        });
    </script>
@endsection
