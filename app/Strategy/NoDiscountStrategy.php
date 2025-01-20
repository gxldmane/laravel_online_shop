<?php

namespace App\Strategy;

class NoDiscountStrategy implements DiscountStrategy
{
    public function applyDiscount($totalPrice)
    {
        return $totalPrice; // Без скидки
    }
}
