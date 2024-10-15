<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\Pizza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->get();
        $totalPrice = $cartItems->sum(function($cartItem) {
            return $cartItem->pizza->price * $cartItem->quantity;
        });

        // Проверяем, сделал ли пользователь заказы
        $userHasOrders = Order::where('user_id', Auth::id())->exists();

        // Если это первый заказ, применяем скидку
        $discount = 0;
        if (!$userHasOrders) {
            $discount = 0.10; // 10% скидка
            $totalPrice = $totalPrice - ($totalPrice * $discount);
        }

        return view('cart.index', compact('cartItems', 'totalPrice', 'discount'));
    }

    public function addToCart(Request $request)
    {
        // Валидация запроса
        $request->validate([
            'pizza_id' => 'required|exists:pizzas,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Получаем пиццу
        $pizza = Pizza::findOrFail($request->input('pizza_id'));

        // Проверяем, есть ли этот товар в корзине
        $existingCartItem = CartItem::where('user_id', Auth::id())
            ->where('pizza_id', $pizza->id)
            ->first();

        if ($existingCartItem) {
            // Если товар уже есть, увеличиваем количество
            $existingCartItem->quantity += $request->input('quantity');
            $existingCartItem->save();
        } else {
            // Иначе создаем новую запись в корзине
            CartItem::create([
                'user_id' => Auth::id(),
                'pizza_id' => $pizza->id,
                'quantity' => $request->input('quantity'),
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Товар добавлен в корзину');
    }


    public function storeOrder(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $cartItems = CartItem::where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        // Проверка на первый заказ
        $userHasOrders = Order::where('user_id', Auth::id())->exists();

        // Итоговая сумма
        $totalPrice = $cartItems->sum(function($cartItem) {
            return $cartItem->pizza->price * $cartItem->quantity;
        });

        // Применение скидки на первый заказ
        if (!$userHasOrders) {
            $totalPrice = $totalPrice - ($totalPrice * 0.10); // 10% скидка
        }

        // Создаем заказ
        $order = Order::create([
            'name' => Auth::user()->name,
            'user_id' => Auth::id(),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'total' => $totalPrice,
        ]);

        // Добавляем пиццы к заказу
        foreach ($cartItems as $cartItem) {
            $order->pizzas()->attach($cartItem->pizza_id, ['quantity' => $cartItem->quantity]);
        }

        // Очищаем корзину
        CartItem::where('user_id', Auth::id())->delete();

        return redirect()->route('orders.success');
    }

    public function removeItem($id)
    {
        $cartItem = CartItem::where('user_id', Auth::id())->findOrFail($id);
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Товар удален из корзины');
    }
}
