@extends('layouts.app')

@section('title', 'Заказ успешно оформлен')

@section('content')
    <div class="container mx-auto mt-10 text-center">
        <h1 class="text-4xl font-bold mb-6">Спасибо за ваш заказ!</h1>
        <p class="text-lg">Ваш заказ успешно оформлен и будет доставлен в ближайшее время.</p>
        <a href="{{ route('home') }}" class="bg-blue-600 text-white rounded px-4 py-2 mt-6 inline-block">Вернуться на главную</a>
    </div>
@endsection
