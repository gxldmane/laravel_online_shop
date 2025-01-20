@extends('layouts.app')

@section('title', 'Создание новой пиццы')

@section('content')
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-6">Создание новой пиццы</h1>

        <form action="{{ route('admin.pizzas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700">Название:</label>
                <input type="text" id="name" name="name" class="border rounded w-full py-2 px-3" value="{{ old('name') }}" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700">Описание:</label>
                <textarea id="description" name="description" class="border rounded w-full py-2 px-3" rows="4" required>{{ old('description') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="price" class="block text-gray-700">Цена:</label>
                <input type="number" id="price" name="price" class="border rounded w-full py-2 px-3" value="{{ old('price') }}" required>
            </div>

            <div class="mb-4">
                <label for="image" class="block text-gray-700">Фото:</label>
                <input type="file" id="image" name="image" class="border rounded w-full py-2 px-3" required>
            </div>

            <div class="mb-4">
                <label for="season_discount">Сезонная скидка (например, 0.10 для 10%):</label>
                <input type="number" name="season_discount" step="0.01" min="0" max="1">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Создать</button>
            </div>
        </form>
    </div>
@endsection
