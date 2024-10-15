<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
<header class="bg-white shadow">
    <div class="container mx-auto px-4 py-3">
        <h1 class="text-2xl font-bold">Доставка Пиццы</h1>
        <nav class="bg-gray-800 p-4">
            <div class="container mx-auto flex justify-between items-center">
                <div class="container">
                    <a href="{{ route('home') }}" class="text-white font-bold">Главная</a>
                    <a href="{{ route('pizzas.index') }}" class="text-white font-bold">Меню</a>
                </div>


                <div class="flex items-center">
                    @auth
                        <a href="{{ route('orders.index') }}" class="text-white mr-4">Мои заказы</a>
                        <a href="{{ route('cart.index') }}" class="text-white mr-4">Корзина</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-white">Выйти</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-white mr-4">Войти</a>
                        <a href="{{ route('register') }}" class="text-white">Регистрация</a>
                    @endauth
                </div>
            </div>
        </nav>
    </div>
</header>

<main class="container mx-auto px-4 py-8">
    @yield('content')
</main>

<footer class="bg-white shadow mt-8">
    <div class="container mx-auto px-4 py-3 text-center">
        <p>© {{ date('Y') }} Доставка Пиццы. Все права защищены.</p>
    </div>
</footer>
</body>
</html>
