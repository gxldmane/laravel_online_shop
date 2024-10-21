<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PizzaAdminController;
use App\Http\Controllers\PizzaController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');

// Аутентификация
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Страница корзины
Route::middleware(['auth'])->group(function () {
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart', [CartController::class, 'storeOrder'])->name('cart.order');
    Route::post('cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
});

// Заказы
Route::middleware(['auth'])->group(function () {
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index')->middleware('auth');
    Route::get('orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
});

Route::get('order/success', function () {
    return view('orders.success');
})->name('orders.success');



// Пиццы
Route::get('/pizzas', [PizzaController::class, 'index'])->name('pizzas.index');
Route::get('/pizzas/{pizza}', [PizzaController::class, 'show'])->name('pizzas.show');

// Административные маршруты (защищены)
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/admin/pizzas', [PizzaAdminController::class, 'index'])->name('admin.pizzas.index');
    Route::get('/admin/pizzas/create', [PizzaAdminController::class, 'create'])->name('admin.pizzas.create');
    Route::post('/admin/pizzas', [PizzaAdminController::class, 'store'])->name('admin.pizzas.store');
    Route::get('/admin/pizzas/{pizza}/edit', [PizzaAdminController::class, 'edit'])->name('admin.pizzas.edit');
    Route::put('/admin/pizzas/{pizza}', [PizzaAdminController::class, 'update'])->name('admin.pizzas.update');
    Route::delete('/admin/pizzas/{pizza}', [PizzaAdminController::class, 'destroy'])->name('admin.pizzas.destroy');
});
