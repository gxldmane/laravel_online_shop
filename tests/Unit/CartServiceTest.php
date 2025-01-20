<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\User;
use App\Models\Pizza;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class CartServiceTest extends TestCase
{
    use RefreshDatabase;

    private $cartService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cartService = app(CartService::class);
    }

    public function testIndexCalculatesTotalPriceWithDiscount()
    {
        $user = User::factory()->create();
        $pizza = Pizza::factory()->create(['price' => 1000]);

        CartItem::create([
            'user_id' => $user->id,
            'pizza_id' => $pizza->id,
            'quantity' => 2,
        ]);

        Auth::login($user);
        $cartItems = CartItem::where('user_id', $user->id)->get();

        $result = $this->cartService->index($cartItems);

        $this->assertEquals(1800, $result['totalPrice']); // 2 * 1000 - 10:
        $this->assertEquals(0.10, $result['discount']);
    }

    public function testCreateCartAddsItemToCart()
    {
        $user = User::factory()->create();
        $pizza = Pizza::factory()->create(['price' => 500]);
        Auth::login($user);

        $this->cartService->createCart($pizza, ['quantity' => 3]);

        $this->assertDatabaseHas('cart_items', [
            'user_id' => $user->id,
            'pizza_id' => $pizza->id,
            'quantity' => 3,
        ]);
    }

    public function testCreateCartIncreasesQuantityIfItemAlreadyInCart()
    {
        $user = User::factory()->create();
        $pizza = Pizza::factory()->create(['price' => 500]);
        CartItem::create(['user_id' => $user->id, 'pizza_id' => $pizza->id, 'quantity' => 2]);
        Auth::login($user);

        $this->cartService->createCart($pizza, ['quantity' => 1]);

        $this->assertDatabaseHas('cart_items', [
            'user_id' => $user->id,
            'pizza_id' => $pizza->id,
            'quantity' => 3,
        ]);
    }

    public function testStoreOrderCreatesOrderAndClearsCart()
    {
        $user = User::factory()->create();
        $pizza = Pizza::factory()->create(['price' => 800]);
        CartItem::create(['user_id' => $user->id, 'pizza_id' => $pizza->id, 'quantity' => 2]);
        Auth::login($user);

        $this->cartService->storeOrder(CartItem::where('user_id', $user->id)->get(), [
            'address' => '123 Pizza St',
            'phone' => '1234567890',
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'address' => '123 Pizza St',
            'total' => 1440, // 2 * 800
        ]);

        $this->assertDatabaseCount('cart_items', 0); // Cart should be empty after order
    }

    public function testGetItemsSumCalculatesCorrectTotal()
    {
        $user = User::factory()->create();
        $pizza1 = Pizza::factory()->create(['price' => 500]);
        $pizza2 = Pizza::factory()->create(['price' => 700]);

        CartItem::create(['user_id' => $user->id, 'pizza_id' => $pizza1->id, 'quantity' => 2]);
        CartItem::create(['user_id' => $user->id, 'pizza_id' => $pizza2->id, 'quantity' => 1]);

        $cartItems = CartItem::where('user_id', $user->id)->get();

        $total = $this->cartService->getItemsSum($cartItems);

        $this->assertEquals(1700, $total); // (2 * 500) + (1 * 700)
    }

    public function testMakeDiscountAppliesFirstOrderDiscount()
    {
        $user = User::factory()->create();
        Auth::login($user);

        list($totalPrice, $discount) = $this->cartService->makeDiscount(1000);

        $this->assertEquals(900, $totalPrice); // 1000 - 10%
        $this->assertEquals(0.10, $discount);
    }

    public function testMakeDiscountNoDiscountForReturningUser()
    {
        $user = User::factory()->create();
        Auth::login($user);

        Order::factory()->create(['user_id' => $user->id]);

        list($totalPrice, $discount) = $this->cartService->makeDiscount(1000);

        $this->assertEquals(1000, $totalPrice);
        $this->assertEquals(0, $discount);
    }

    public function testCreateCartFailsWithoutAuthentication()
    {
        Auth::logout();
        $pizza = Pizza::factory()->create();

        $this->expectException(\Exception::class);

        $this->cartService->createCart($pizza, ['quantity' => 1]);
    }

    public function testCreateCartFailsWhenPizzaDoesNotExist()
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $this->cartService->createCart(Pizza::findOrFail(999), ['quantity' => 1]);
    } }
