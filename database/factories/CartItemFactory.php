<?php

namespace Database\Factories;

use App\Models\CartItem;
use App\Models\Pizza;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartItemFactory extends Factory
{
    protected $model = CartItem::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'pizza_id' => Pizza::factory(),
            'quantity' => $this->faker->numberBetween(1, 10),
        ];
    }
}
