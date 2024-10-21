@extends('layouts.app')

@section('title', 'Управление пиццами')

@section('content')
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-6">Управление пиццами</h1>

        <a href="{{ route('admin.pizzas.create') }}" class="bg-green-600 text-white rounded px-4 py-2">Создать пиццу</a>

        @if($pizzas->isEmpty())
            <p>Нет пицц для отображения.</p>
        @else
            <table class="mt-6 w-full">
                <thead>
                <tr>
                    <th class="border px-4 py-2">Название</th>
                    <th class="border px-4 py-2">Описание</th>
                    <th class="border px-4 py-2">Цена</th>
                    <th class="border px-4 py-2">Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pizzas as $pizza)
                    <tr>
                        <td class="border px-4 py-2">{{ $pizza->name }}</td>
                        <td class="border px-4 py-2">{{ $pizza->description }}</td>
                        <td class="border px-4 py-2">{{ $pizza->price }} руб.</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('admin.pizzas.edit', $pizza->id) }}" class="text-blue-600">Редактировать</a>
                            <form action="{{ route('admin.pizzas.destroy', $pizza->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 ml-4">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
