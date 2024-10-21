<?php

namespace App\Http\Controllers;

use App\Models\Pizza;

class PizzaController extends Controller
{
    public function index()
    {
        $pizzas = Pizza::all();
        return view('pizzas.index')->with([
            'pizzas' => $pizzas
        ]);
    }

    public function show(Pizza $pizza)
    {
        return view('pizzas.show')->with([
            'pizza' => $pizza
        ]);
    }
}
