<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Requests\Cart\StoreCartRequest;
use App\Models\CartItem;
use App\Models\Pizza;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct(private CartService $service)
    {
    }

    public function index()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->get();

        $data = $this->service->index($cartItems);

        return view('cart.index')->with([
            'cartItems' => $cartItems,
            'totalPrice' => $data['totalPrice'],
            'discount' => $data['discount']
        ]);
    }

    public function addToCart(AddToCartRequest $request)
    {
        $data = $request->validated();

        $pizza = Pizza::findOrFail($data['pizza_id']);

        $this->service->createCart($pizza, $data);

        return redirect()->route('cart.index')->with('success', 'Товар добавлен в корзину');
    }


    public function storeOrder(StoreCartRequest $request)
    {
        $data = $request->validated();

        $cartItems = CartItem::where('user_id', Auth::id())->get();

        $this->service->storeOrder($cartItems, $data);

        return redirect()->route('orders.success');
    }

    public function removeItem($id)
    {
        $cartItem = CartItem::where('user_id', Auth::id())->findOrFail($id);
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Товар удален из корзины');
    }
}
