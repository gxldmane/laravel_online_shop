<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiService
{
    public function cartIndex($data)
    {
        return Http::post("http://192.168.90.251:8081/api/cart/index", $data)->json();
    }

    public function createCart($data)
    {
        return Http::post("http://192.168.90.251:8081/api/cart/createCart", $data)->json();
    }

    public function storeOrder($data)
    {
        return Http::post("http://192.168.90.251:8081/api/cart/storeOrder", $data)->json();
    }

    public function removeItem($data)
    {
        return Http::post("http://192.168.90.251:8081/api/cart/removeItem", $data)->json();
    }

    public function orderIndex($data)
    {
        return Http::post("http://192.168.90.251:8081/api/order/index", $data)->json();
    }
}
