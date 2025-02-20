<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    //
    public function show(Order $order)
{
    if ($order->user_id !== auth()->id()) {
        abort(403);
    }

    return view('pages.orders.show', compact('order'))
        ->with(['title' => 'Order Details']);
}

}
