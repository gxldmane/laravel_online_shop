<?php

namespace Database\Factories;

use App\Models\Pizza;
use Illuminate\Database\Eloquent\Factories\Factory;

class PizzaFactory extends Factory
{
    protected $model = Pizza::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word . ' Pizza', // Название пиццы
            'description' => $this->faker->sentence(10), // Описание
            'price' => $this->faker->numberBetween(300, 1500), // Цена в рублях
            'image' => $this->faker->imageUrl(640, 480, 'food'), // URL изображения
        ];
    }
}
