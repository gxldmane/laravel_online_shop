<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function index($cartItems)
    {
        $totalPrice = $this->getItemsSum($cartItems);
        list($totalPrice, $discount) = $this->makeDiscount($totalPrice);

        return [
            'totalPrice' => $totalPrice,
            'discount' => $discount
        ];
    }

    public function createCart($pizza, $data)
    {
        if (!Auth::user()) {
            throw new \Exception('User is not authenticated');
        }

        if (!$pizza) {
            throw new \Exception('Pizza is not found');
        }

        $existingCartItem = CartItem::where('user_id', Auth::id())
            ->where('pizza_id', $pizza->id)
            ->first();

        if ($existingCartItem) {
            $existingCartItem->quantity += $data['quantity'];
            $existingCartItem->save();
        } else {
            CartItem::create([
                'user_id' => Auth::id(),
                'pizza_id' => $pizza->id,
                'quantity' => $data['quantity'],
            ]);
        }
    }

    public function storeOrder($cartItems, $data)
    {
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        $totalPrice = $this->getItemsSum($cartItems);

        list($totalPrice, $discount) = $this->makeDiscount($totalPrice);

        $order = Order::create([
            'name' => Auth::user()->name,
            'user_id' => Auth::id(),
            'address' => $data['address'],
            'phone' => $data['phone'],
            'total' => $totalPrice,
        ]);

        foreach ($cartItems as $cartItem) {
            $order->pizzas()->attach($cartItem->pizza_id, ['quantity' => $cartItem->quantity]);
        }

        CartItem::where('user_id', Auth::id())->delete();
    }

    public function getItemsSum($cartItems)
    {
        return $cartItems->sum(function ($cartItem) {
            return $cartItem->pizza->price * $cartItem->quantity;
        });
    }

    public function makeDiscount($totalPrice)
    {
        $userHasOrders = Order::where('user_id', Auth::id())->exists();

        $discount = 0;
        if (!$userHasOrders) {
            $discount = 0.10;
            $totalPrice = $totalPrice - ($totalPrice * $discount);
        }
        return [$totalPrice, $discount];
    }
}
