<?php

namespace App\Http\Controllers;

use App\Factories\DefaultPizzaFactory;
use App\Http\Requests\Pizza\PizzaStoreRequest;
use App\Http\Requests\Pizza\PizzaUpdateRequest;
use App\Models\Pizza;

class PizzaAdminController extends Controller
{
    public function index()
    {
        $pizzas = Pizza::all();
        return view('admin.pizzas.index')->with([
            'pizzas' => $pizzas
        ]);
    }

    public function create()
    {
        return view('admin.pizzas.create');
    }

    public function store(PizzaStoreRequest $request)
    {
        $factory = new DefaultPizzaFactory();

        $pizza = $factory->createPizza(
            $request->name,
            $request->price,
            $request->image,
            $request->description
        );

        $pizza->save();

        return redirect()->route('admin.pizzas.index')->with('success', 'Пицца успешно создана.');
    }

    public function edit(Pizza $pizza)
    {
        return view('admin.pizzas.edit')->with([
            'pizza' => $pizza
        ]);
    }

    public function update(PizzaUpdateRequest $request, Pizza $pizza)
    {
        $data = $request->validated();

        $pizza->update($data);

        return redirect()->route('admin.pizzas.index')->with('success', 'Пицца успешно обновлена.');
    }

    public function destroy(Pizza $pizza)
    {
        $pizza->delete();

        return redirect()->route('admin.pizzas.index')->with('success', 'Пицца успешно удалена.');
    }
}
