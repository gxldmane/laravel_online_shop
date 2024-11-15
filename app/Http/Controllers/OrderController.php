<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::query()->where('user_id', Auth::id())->with('pizzas')->get();
        return view('orders.index')->with(['orders' => $orders]);
    }
}
