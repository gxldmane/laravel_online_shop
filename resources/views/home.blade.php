@extends('layouts.app')

@section('title', 'Добро пожаловать в нашу пиццерию')

@section('content')
    <div class="text-center mt-20">
        <h1 class="text-5xl font-bold mb-4">Добро пожаловать в нашу пиццерию!</h1>
        <p class="text-lg mb-6">Мы готовим лучшие пиццы в городе с любовью и свежими ингредиентами.</p>
        <p class="text-lg mb-4">Заказывайте прямо сейчас и наслаждайтесь вкусом!</p>
        <a href="{{ route('pizzas.index') }}" class="bg-blue-600 text-white rounded px-6 py-3 mt-4">Посмотреть меню</a>
    </div>

    <div class="mt-20">
        <h2 class="text-3xl font-bold text-center mb-4">Почему выбирают нас?</h2>
        <ul class="max-w-xl mx-auto text-lg">
            <li class="mb-2">🍕 Свежие ингредиенты</li>
            <li class="mb-2">🚚 Быстрая доставка</li>
            <li class="mb-2">❤️ Уникальные рецепты</li>
            <li class="mb-2">🌟 Отличное обслуживание</li>
        </ul>
    </div>

    <div class="mt-20">
        <h2 class="text-3xl font-bold text-center mb-4">Не упустите акцию!</h2>
        <p class="text-lg mb-6">При заказе через сайт вы получаете скидку 10% на первый заказ!</p>
        <a href="{{ route('register') }}" class="bg-green-600 text-white rounded px-6 py-3">Зарегистрироваться и получить скидку</a>
    </div>
@endsection
