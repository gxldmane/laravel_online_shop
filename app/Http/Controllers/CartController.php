<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Requests\Cart\StoreCartRequest;
use App\Models\Pizza;
use App\Services\ApiService;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct(private ApiService $service)
    {
    }

    public function index()
    {
        $data = $this->service->cartIndex(['userId' => Auth::id()]);
        return view('cart.index')->with([
            'cartItems' => $data['cartItems'],
            'totalPrice' => $data['totalPrice'],
            'discount' => $data['discount']
        ]);
    }

    public function addToCart(AddToCartRequest $request)
    {
        $data = $request->validated();
        $pizza = Pizza::findOrFail($data['pizza_id']);
        $quantity = $data['quantity'];
        $data = $this->service->createCart(['userId' => Auth::id(), 'pizzaId' => $pizza->id, 'quantity' => $quantity]);
        return redirect()->route('cart.index')->with('success', 'Товар добавлен в корзину');
    }


    public function storeOrder(StoreCartRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();

        $data = $this->service->storeOrder(['user' => $user, 'data' => $data]);

        return redirect()->route('orders.success');
    }

    public function removeItem($id)
    {
        $userId = Auth::id();
        $data = $this->service->removeItem(['userId' => $userId, 'cartItemId' => $id]);
        return redirect()->route('cart.index')->with('success', 'Товар удален из корзины');
    }
}
