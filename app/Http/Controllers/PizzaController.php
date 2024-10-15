<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
    // Получить все пиццы
    public function index()
    {
        $pizzas = Pizza::all();
        return view('pizzas.index', compact('pizzas'));
    }

    // Показать форму для создания новой пиццы
    public function create()
    {
        return view('pizzas.create');
    }

    // Сохранить новую пиццу
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048', // Ограничение на изображение
        ]);

        $pizza = Pizza::create($request->all());

        return redirect()->route('pizzas.index')->with('success', 'Пицца успешно добавлена.');
    }

    // Показать конкретную пиццу
    public function show(Pizza $pizza)
    {
        return view('pizzas.show', compact('pizza'));
    }

    // Показать форму для редактирования пиццы
    public function edit(Pizza $pizza)
    {
        return view('pizzas.edit', compact('pizza'));
    }

    // Обновить пиццу
    public function update(Request $request, Pizza $pizza)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        $pizza->update($request->all());

        return redirect()->route('pizzas.index')->with('success', 'Пицца успешно обновлена.');
    }

    // Удалить пиццу
    public function destroy(Pizza $pizza)
    {
        $pizza->delete();
        return redirect()->route('pizzas.index')->with('success', 'Пицца успешно удалена.');
    }
}
