@extends('layouts.app')

@section('title', 'Создание заказа')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Создание заказа</h2>
    <form action="{{ route('orders.store') }}" method="POST" class="bg-white p-4 rounded-lg shadow">
        @csrf
        <div class="mb-4">
            <label for="name" class="block mb-2">Имя</label>
            <input type="text" name="name" id="name" required class="border rounded w-full p-2">
        </div>
        <div class="mb-4">
            <label for="phone" class="block mb-2">Телефон</label>
            <input type="text" name="phone" id="phone" required class="border rounded w-full p-2">
        </div>
        <div class="mb-4">
            <label for="address" class="block mb-2">Адрес</label>
            <input type="text" name="address" id="address" required class="border rounded w-full p-2">
        </div>
        <div class="mb-4">
            <label for="total" class="block mb-2">Итоговая цена</label>
            <input type="text" name="total" id="total" value="0" readonly class="border rounded w-full p-2">
        </div>
        <button type="submit" class="bg-blue-600 text-white rounded px-3 py-1">Создать заказ</button>
    </form>
@endsection
