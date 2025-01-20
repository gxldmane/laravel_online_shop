@extends('layouts.app')

@section('title', 'Меню пицц')

@section('content')
    <div class="container mx-auto mt-10">
        <h1 class="text-4xl font-bold mb-6">Меню пицц</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($pizzas as $pizza)
                <div class="bg-white shadow-md rounded p-4">
                    <img src="{{ $pizza->image }}" alt="{{ $pizza->name }}" class="mb-4">
                    <h2 class="text-2xl font-semibold">{{ $pizza->name }}</h2>
                    <p class="text-lg font-bold mt-4">Цена: {{ $pizza->price }} руб.</p>
                    <!-- Форма для добавления в корзину -->
                    <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="pizza_id" value="{{ $pizza->id }}">
                        <label for="quantity_{{ $pizza->id }}" class="block text-sm font-semibold mb-2">Количество</label>
                        <input type="number" name="quantity" id="quantity_{{ $pizza->id }}" value="1" min="1" class="border rounded w-20 p-2 mb-2">
                        <button type="submit" class="bg-blue-600 text-white rounded px-4 py-2">Добавить в корзину</button>
                    </form>

                    <!-- Кнопка "Подробнее" для перехода на страницу пиццы -->
                    <a href="{{ route('pizzas.show', $pizza->id) }}" class="block mt-4 bg-green-500 text-white rounded px-4 py-2 text-center">Подробнее</a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
