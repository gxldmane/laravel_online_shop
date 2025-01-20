<?php

namespace App\Factories;

use App\Models\Pizza;

abstract class PizzaFactory
{
    abstract public function createPizza($name, $price, $image, $description): Pizza;
}
