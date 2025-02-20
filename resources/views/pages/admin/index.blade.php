@extends('layouts.user')
@section('content')
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:p>{{ $title }}</x-slot:p>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @foreach ($financialData as $key => $data)
            @php
                $growth = round((($data['current'] - $data['previous']) / $data['previous']) * 100, 1);
                $isPositive = $growth >= 0;
            @endphp
            <div class="bg-white p-4 shadow rounded-lg flex flex-col">
                <h3 class="text-gray-600 capitalize">{{ ucfirst($key) }}</h3>
                <p class="text-2xl font-semibold text-gray-900">${{ number_format($data['current']) }}</p>
                <p class="text-sm flex items-center gap-1 {{ $isPositive ? 'text-green-500' : 'text-red-500' }}">
                    {{ $isPositive ? '+' : '' }}{{ $growth }}% from last month
                    <span class="inline-block">
                        @if ($isPositive)
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                fill="#00c217">
                                <path
                                    d="m136-240-56-56 296-298 160 160 208-206H640v-80h240v240h-80v-104L536-320 376-480 136-240Z" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                fill="#EA3323">
                                <path
                                    d="M640-240v-80h104L536-526 376-366 80-664l56-56 240 240 160-160 264 264v-104h80v240H640Z" />
                            </svg>
                        @endif
                    </span>
                </p>
                <div id="{{ $key }}_chart" class="mt-2" style="width: 100%; height: 40px;"></div>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white p-6 shadow rounded-lg">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Total Sales</h3>
            <div id="sales_chart" style="width: 100%; height: 300px;"></div>
        </div>
        <div class="bg-white p-6 shadow rounded-lg">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Medicines</h3>
            <div id="category_sales" style="width: 100%; height: 300px;"></div>
        </div>
    </div>

    <div class="bg-white p-6 shadow rounded-lg mt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Income</h3>
        <div id="sales_funnel" style="width: 100%; height: 300px;"></div>
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
            height: 40,
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
            title: 'Total Sales',
            colors: ['#1E88E5']
        };
        var chart = new google.visualization.ColumnChart(document.getElementById('sales_chart'));
        chart.draw(data, options);
    }

    function drawSalesFunnel() {
        var data = google.visualization.arrayToDataTable(@json($salesFunnel));
        var options = {
            title: 'Per days',
            colors: ['#43A047']
        };
        var chart = new google.visualization.AreaChart(document.getElementById('sales_funnel'));
        chart.draw(data, options);
    }

    function drawCategorySales() {
        var data = google.visualization.arrayToDataTable(@json($categorySales))
        var options = {
            title: 'Most Popular',
            pieHole: 0.4,
            colors: ['#FF9800', '#8E24AA', '#D81B60']
        };
        var chart = new google.visualization.PieChart(document.getElementById('category_sales'));
        chart.draw(data, options);
    }
</script>
