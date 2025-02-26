<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

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
            // Data dashboard untuk admin tetap sama seperti sebelumnya
            $salesData = [
                ['Day', 'Sales'],
                ['Mon', 1000],
                ['Tue', 1500],
                ['Wed', 1200],
                ['Thu', 1800],
                ['Fri', 2000],
                ['Sat', 3100],
                ['Sun', 1500],
            ];

            $salesFunnel = [
                ['Stage', 'Value'],
                ['1 Jan', 4562],
                ['2 Jan', 2562],
                ['3 Jan', 1262],
                ['4 Jan', 1000],
                ['5 Jan', 4000],
                ['6 Jan', 4530],
                ['7 Jan', 5000],
            ];

            $categorySales = [
                ['Category', 'Sales'],
                ['Paracetamol', 25],
                ['Panadol', 35],
                ['Tolak Angin', 40],
            ];

            $financialData = [
                'revenue' => [
                    'current' => 4562,
                    'previous' => 2500,
                    'chartData' => [0, 2200, 2900, 9800, 3000, 3500, 1000, 7200, 4500, 4562]
                ],
                'visitors' => [
                    'current' => 2562,
                    'previous' => 1800,
                    'chartData' => [1500, 0, 2900, 900, 3000, 3500, 5000, 2200, 2500, 4562]
                ],
                'transactions' => [
                    'current' => 2262,
                    'previous' => 2300,
                    'chartData' => [2500, 2450, 2400, 2350, 2300, 2280, 2270, 2265, 2263, 2262]
                ],
                'products' => [
                    'current' => 2100,
                    'previous' => 1500,
                    'chartData' => [1000, 1200, 1300, 1400, 1600, 1800, 1900, 2000, 2050, 2100]
                ],
            ];

            return view('pages.admin.index',  compact('salesData', 'salesFunnel', 'categorySales', 'financialData'))
                ->with(['title' => 'Dashboard']);
        }
    }
}
