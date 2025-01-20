<?php

namespace App\Strategy;

interface DiscountStrategy
{
    public function applyDiscount($totalPrice);
}
