@extends('layouts.app')

@section('title', 'Мои заказы')

@section('content')
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-6">Мои заказы</h1>

        @if($orders->isEmpty())
            <p>У вас еще нет заказов.</p>
        @else
            @foreach($orders as $order)
                <div class="border p-4 rounded mb-4">
                    <h2 class="text-2xl font-semibold mb-2">Заказ #{{ $order->id }} от {{ $order->created_at->format('d.m.Y') }}</h2>
                    <p><strong>Адрес доставки:</strong> {{ $order->address }}</p>
                    <p><strong>Телефон:</strong> {{ $order->phone }}</p>
                    <p><strong>Итоговая сумма:</strong> {{ $order->total }} руб.</p>

                    <h3 class="text-xl font-semibold mt-4">Пиццы в заказе:</h3>
                    <ul>
                        @foreach($order->pizzas as $pizza)
                            <li>{{ $pizza->name }} (количество: {{ $pizza->pivot->quantity }})</li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        @endif
    </div>
@endsection
