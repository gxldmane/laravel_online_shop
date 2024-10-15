<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::query()->where('user_id', Auth::id())->with('pizzas')->get();
        return view('orders.index', compact('orders'));
    }

    // Показать форму для создания заказа
    public function create()
    {
        return view('orders.create');
    }

    // Сохранить заказ
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'total' => 'required|numeric',
        ]);

        $order = Order::create($request->all());

        return redirect()->route('home')->with('success', 'Заказ успешно создан.');
    }
}
