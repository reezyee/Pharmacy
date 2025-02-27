@extends('layouts.user')
@section('content')
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:p>{{ $title }}</x-slot:p>
    
    <!-- Financial Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @foreach ($financialData as $key => $data)
            @php
                $growth = round((($data['current'] - $data['previous']) / $data['previous']) * 100, 1);
                $isPositive = $growth >= 0;
            @endphp
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                <div class="p-5">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-gray-600 font-medium capitalize">{{ ucfirst($key) }}</h3>
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $isPositive ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                            {{ $isPositive ? '+' : '' }}{{ $growth }}%
                        </span>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">${{ number_format($data['current']) }}</p>
                    <p class="text-sm text-gray-500 flex items-center gap-1">
                        compared to last month
                        <span class="inline-block">
                            @if ($isPositive)
                                <svg xmlns="http://www.w3.org/2000/svg" height="16px" viewBox="0 -960 960 960" width="16px"
                                    fill="#00c217">
                                    <path
                                        d="m136-240-56-56 296-298 160 160 208-206H640v-80h240v240h-80v-104L536-320 376-480 136-240Z" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" height="16px" viewBox="0 -960 960 960" width="16px"
                                    fill="#EA3323">
                                    <path
                                        d="M640-240v-80h104L536-526 376-366 80-664l56-56 240 240 160-160 264 264v-104h80v240H640Z" />
                                </svg>
                            @endif
                        </span>
                    </p>
                </div>
                <div id="{{ $key }}_chart" style="width: 100%; height: 60px;"></div>
            </div>
        @endforeach
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Sales Chart Card -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
            <div class="p-5 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">Total Sales</h3>
                <p class="text-sm text-gray-500">Weekly sales performance</p>
            </div>
            <div class="p-5">
                <div id="sales_chart" style="width: 100%; height: 300px;"></div>
            </div>
        </div>
        
        <!-- Medicine Chart Card -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
            <div class="p-5 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">Medicines</h3>
                <p class="text-sm text-gray-500">Category distribution</p>
            </div>
            <div class="p-5">
                <div id="category_sales" style="width: 100%; height: 300px;"></div>
            </div>
        </div>
    </div>

    <!-- Income Card -->
    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden mb-8">
        <div class="p-5 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Income</h3>
            <p class="text-sm text-gray-500">Daily income trends</p>
        </div>
        <div class="p-5">
            <div id="sales_funnel" style="width: 100%; height: 300px;"></div>
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
        @foreach ($financialData as $key => $data)
            drawMiniChart('{{ $key }}', @json($data['chartData']));
        @endforeach

        drawSalesChart();
        drawSalesFunnel();
        drawCategorySales();
    }

    function drawMiniChart(container, chartData) {
        var data = new google.visualization.DataTable();
        data.addColumn('number', 'X');
        data.addColumn('number', 'Value');
        let rows = chartData.map((value, index) => [index, value]);
        data.addRows(rows);

        var options = {
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

        var chart = new google.visualization.LineChart(document.getElementById(container + '_chart'));
        chart.draw(data, options);
    }

    function drawSalesChart() {
        var data = google.visualization.arrayToDataTable([
            ['Day', 'Sales'],
            ['Mon', 1000],
            ['Tue', 1170],
            ['Wed', 660],
            ['Thu', 1030],
            ['Fri', 2000],
            ['Sat', 3000],
            ['Sun', 2500]
        ]);
        var options = {
            title: '',
            colors: ['#1E88E5'],
            legend: { position: 'none' },
            chartArea: {
                width: '90%',
                height: '80%'
            },
        };
        var chart = new google.visualization.ColumnChart(document.getElementById('sales_chart'));
        chart.draw(data, options);
    }

    function drawSalesFunnel() {
        var data = google.visualization.arrayToDataTable(@json($salesFunnel));
        var options = {
            title: '',
            colors: ['#43A047'],
            legend: { position: 'none' },
            chartArea: {
                width: '90%',
                height: '80%'
            },
        };
        var chart = new google.visualization.AreaChart(document.getElementById('sales_funnel'));
        chart.draw(data, options);
    }

    function drawCategorySales() {
        var data = google.visualization.arrayToDataTable(@json($categorySales))
        var options = {
            title: '',
            pieHole: 0.4,
            colors: ['#FF9800', '#8E24AA', '#D81B60'],
            chartArea: {
                width: '90%',
                height: '80%'
            },
        };
        var chart = new google.visualization.PieChart(document.getElementById('category_sales'));
        chart.draw(data, options);
    }
</script>