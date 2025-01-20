<?php

namespace App\Strategy;

class FirstOrderDiscountStrategy implements DiscountStrategy
{
    public function applyDiscount($totalPrice)
    {
        return $totalPrice * 0.9; // 10% скидка для новых пользователей
    }
}
