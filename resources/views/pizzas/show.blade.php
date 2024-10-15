@extends('layouts.app')

@section('title', $pizza->name)

@section('content')
    <div class="bg-white p-4 rounded-lg shadow">
        <img src="{{ $pizza->image }}" alt="{{ $pizza->name }}" class="h-60 w-full object-cover rounded-t-lg">
        <h3 class="text-2xl font-semibold mt-2">{{ $pizza->name }}</h3>
        <p class="mt-1">{{ $pizza->description }}</p>
        <p class="text-lg font-bold mt-2">{{ $pizza->price }} руб.</p>
        <form action="{{ route('cart.order') }}" method="POST" class="mt-4">
            @csrf
            <input type="hidden" name="pizza_id" value="{{ $pizza->id }}">
            <input type="number" name="quantity" value="1" min="1" class="border rounded p-1 w-20">
            <button type="submit" class="bg-blue-600 text-white rounded px-3 py-1 mt-1">Добавить в корзину</button>
        </form>
    </div>
@endsection
