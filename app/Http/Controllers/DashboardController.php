<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->role_id == 5) {
            $userId = Auth::id();

            // Mengambil total pesanan berdasarkan user_id
            $totalOrders = Order::where('user_id', $userId)->count();
            $completedOrders = Order::where('user_id', $userId)->where('status', 'completed')->count();
            $cancelledOrders = Order::where('user_id', $userId)->where('status', 'cancelled')->count();

            $recentOrders = Order::where('user_id', $userId)
                ->latest() // Urutkan dari yang terbaru
                ->limit(5)
                ->get();

            $pendingOrders = Order::where('user_id', $userId)->where('status', 'pending')->count();
            $processingOrders = Order::where('user_id', $userId)->where('status', 'processing')->count();
            $completedOrders = Order::where('user_id', $userId)->where('status', 'completed')->count();
            $cancelledOrders = Order::where('user_id', $userId)->where('status', 'cancelled')->count();

            return view('pages.user.index', compact('totalOrders', 'completedOrders', 'cancelledOrders', 'recentOrders',  'pendingOrders', 'processingOrders', 'completedOrders', 'cancelledOrders'))
                ->with(['title' => 'Dashboard']);
        } else {
            // Admin Dashboard - Make it dynamic

            // Get weekly sales data for sales chart
            $salesData = [['Day', 'Sales']];
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $dayName = $date->format('D');

                $daySales = Order::whereDate('created_at', $date->toDateString())
                    ->where('status', '!=', 'cancelled')
                    ->sum('total_amount');

                $salesData[] = [$dayName, (float)$daySales];
            }

            // Get daily income for sales funnel (last 7 days)
            $salesFunnel = [['Stage', 'Value']];
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $dateName = $date->format('j M');

                $dayIncome = Order::whereDate('created_at', $date->toDateString())
                    ->where('status', '!=', 'cancelled')
                    ->sum('total_amount');

                $salesFunnel[] = [$dateName, (float)$dayIncome];
            }

            // Get category sales data
            $categorySales = [['Category', 'Sales']];
            $kategoris = DB::table('obats')
                ->join('kategoris', 'obats.kategori_id', '=', 'kategoris.id')
                ->join('order_items', 'obats.id', '=', 'order_items.obat_id')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->where('orders.status', '!=', 'cancelled')
                ->select('kategoris.nama', DB::raw('SUM(order_items.subtotal) as total'))
                ->groupBy('kategoris.nama')
                ->orderBy('total', 'desc')
                ->limit(3)
                ->get();

            foreach ($kategoris as $kategori) {
                $categorySales[] = [$kategori->nama, (float)$kategori->total];
            }

            // Get financial data
            $currentMonth = Carbon::now()->startOfMonth();
            $previousMonth = Carbon::now()->subMonth()->startOfMonth();

            // Calculate revenue
            $currentRevenue = Order::where('status', '!=', 'cancelled')
                ->whereMonth('created_at', $currentMonth->month)
                ->whereYear('created_at', $currentMonth->year)
                ->sum('total_amount');

            $previousRevenue = Order::where('status', '!=', 'cancelled')
                ->whereMonth('created_at', $previousMonth->month)
                ->whereYear('created_at', $previousMonth->year)
                ->sum('total_amount');

            // Get revenue chart data for last 10 days
            $revenueChartData = [];
            for ($i = 9; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $dayRevenue = Order::whereDate('created_at', $date->toDateString())
                    ->where('status', '!=', 'cancelled')
                    ->sum('total_amount');

                $revenueChartData[] = (float)$dayRevenue;
            }

            // Calculate visitors (using orders as proxy for visitors)
            $currentVisitors = Order::whereMonth('created_at', $currentMonth->month)
                ->whereYear('created_at', $currentMonth->year)
                ->count();

            $previousVisitors = Order::whereMonth('created_at', $previousMonth->month)
                ->whereYear('created_at', $previousMonth->year)
                ->count();

            // Get visitors chart data
            $visitorsChartData = [];
            for ($i = 9; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $dayVisitors = Order::whereDate('created_at', $date->toDateString())->count();
                $visitorsChartData[] = $dayVisitors;
            }

            // Calculate transactions
            $currentTransactions = Order::whereMonth('created_at', $currentMonth->month)
                ->whereYear('created_at', $currentMonth->year)
                ->count();

            $previousTransactions = Order::whereMonth('created_at', $previousMonth->month)
                ->whereYear('created_at', $previousMonth->year)
                ->count();

            // Get transactions chart data
            $transactionsChartData = [];
            for ($i = 9; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $dayTransactions = Order::whereDate('created_at', $date->toDateString())->count();
                $transactionsChartData[] = $dayTransactions;
            }

            // Calculate products
            $currentProducts = Obat::where('is_available', true)->count();
            $previousProducts = DB::table('obats')
                ->where('created_at', '<', $currentMonth)
                ->where('is_available', true)
                ->count();

            // Create products chart data (could be inventory levels over time)
            $productsChartData = [];
            for ($i = 9; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                // This is just an example - you might want to track inventory differently
                $products = Obat::where('created_at', '<=', $date)
                    ->where('is_available', true)
                    ->count();

                $productsChartData[] = $products;
            }

            $financialData = [
                'revenue' => [
                    'current' => $currentRevenue,
                    'previous' => $previousRevenue ?: 1, // Avoid division by zero
                    'chartData' => $revenueChartData
                ],
                'visitors' => [
                    'current' => $currentVisitors,
                    'previous' => $previousVisitors ?: 1,
                    'chartData' => $visitorsChartData
                ],
                'transactions' => [
                    'current' => $currentTransactions,
                    'previous' => $previousTransactions ?: 1,
                    'chartData' => $transactionsChartData
                ],
                'products' => [
                    'current' => $currentProducts,
                    'previous' => $previousProducts ?: 1,
                    'chartData' => $productsChartData
                ],
            ];

            return view('pages.admin.index', compact('salesData', 'salesFunnel', 'categorySales', 'financialData'))
                ->with(['title' => 'Dashboard']);
        }
    }
}
