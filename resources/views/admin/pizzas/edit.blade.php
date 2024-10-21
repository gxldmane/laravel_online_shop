@extends('layouts.app')

@section('title', 'Редактирование пиццы')

@section('content')
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-6">Редактирование пиццы</h1>

        <form action="{{ route('admin.pizzas.update', $pizza->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-gray-700">Название:</label>
                <input type="text" id="name" name="name" class="border rounded w-full py-2 px-3" value="{{ old('name', $pizza->name) }}" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700">Описание:</label>
                <textarea id="description" name="description" class="border rounded w-full py-2 px-3" rows="4" required>{{ old('description', $pizza->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label for="price" class="block text-gray-700">Цена:</label>
                <input type="number" id="price" name="price" class="border rounded w-full py-2 px-3" value="{{ old('price', $pizza->price) }}" required>
            </div>

            <div class="mb-4">
                <label for="image" class="block text-gray-700">Фото:</label>
                <input type="file" id="image" name="image" class="border rounded w-full py-2 px-3">
                @if ($pizza->image)
                    <p class="mt-2">Текущее фото: <img src="{{ asset('storage/' . $pizza->image) }}" alt="{{ $pizza->name }}" class="h-20"></p>
                @endif
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Обновить</button>
            </div>
        </form>
    </div>
@endsection
