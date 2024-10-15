@extends('layouts.app')

@section('title', 'Корзина')

@section('content')
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-6">Корзина</h1>

        @if (session('error'))
            <div class="bg-red-500 text-white p-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if($cartItems->isEmpty())
            <p>Ваша корзина пуста.</p>
        @else
            <div class="grid grid-cols-1 gap-6">
                @foreach($cartItems as $item)
                    <div class="border p-4 rounded shadow flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold">{{ $item->pizza->name }}</h3>
                            <p>{{ $item->pizza->description }}</p>
                            <p>Количество: {{ $item->quantity }}</p>
                            <p>Цена: {{ $item->pizza->price }} руб.</p>
                        </div>
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white rounded px-4 py-2">Удалить</button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                <h2 class="text-2xl font-bold mb-4">Итоговая сумма: {{ $totalPrice }} руб.</h2>

                @if($discount > 0)
                    <p class="text-green-600">Скидка на первый заказ: 10%</p>
                @endif
            </div>

            <!-- Форма для оформления заказа -->
            <form action="{{ route('cart.order') }}" method="POST" class="mt-6">
                @csrf
                <div class="mb-4">
                    <label for="address" class="block text-lg font-semibold">Адрес доставки</label>
                    <input type="text" name="address" id="address" class="border rounded w-full p-2 mt-2" required>
                </div>

                <!-- Поле для телефона -->
                <div class="mb-4">
                    <label for="phone" class="block text-lg font-semibold">Номер телефона</label>
                    <input type="text" name="phone" id="phone" class="border rounded w-full p-2 mt-2" required>
                </div>

                <button type="submit" class="bg-green-600 text-white rounded px-4 py-2">Оформить заказ</button>
            </form>
        @endif
    </div>
@endsection
