<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    public function __construct(private ApiService $service)
    {
    }

    public function index()
    {
        $orders = $this->service->orderIndex(['userId' => Auth::id()]);
        return view('orders.index')->with(['orders' => $orders]);
    }
}
