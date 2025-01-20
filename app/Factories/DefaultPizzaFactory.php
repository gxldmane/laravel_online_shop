<?php

namespace App\Factories;

use App\Models\Pizza;

class DefaultPizzaFactory extends PizzaFactory
{
    public function createPizza($name, $price, $image, $description): Pizza
    {
        return new Pizza([
            'name' => $name,
            'price' => $price,
            'image' => $image,
            'description' => $description,
        ]);
    }
}
