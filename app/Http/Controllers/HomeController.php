<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $pizzas = Pizza::all(); // Получаем все пиццы
        return view('home', compact('pizzas')); // Передаем пиццы в представление
    }
}
