<?php

namespace Tests\Feature\Repositories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Interfaces\CartRepositoryInterface;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Collection;

class CartRepositoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @var CartRepositoryInterface
     */
    private $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->app->make(CartRepositoryInterface::class);
    }

    public function testGetAll()
    {
        $user = User::factory()->create();
        $userId = $user->getKey();

        Cart::factory()->count(5)->create([
            'user_id' => $userId
        ]);

        $carts = $this->repository->getAll($userId);

        $this->assertInstanceOf(Collection::class, $carts);

        foreach ($carts as $cart)
            $this->assertInstanceOf(Cart::class, $cart);
    }

    public function testAddProduct()
    {
        $user = User::factory()->create();
        $userId = $user->getKey();
        $product = Product::factory()->create();
        $productId = $product->getKey();

        $carts = $this->repository->update([
            'user_id' => $userId,
            'product_id' => $productId,
            'quantity' => 100
        ]);

        $this->assertDatabaseHas('carts', [
            'user_id' => $userId,
            'product_id' => $productId,
            'quantity' => 100
        ]);
    }

    public function testUpdateQuantity()
    {
        $user = User::factory()->create();
        $userId = $user->getKey();

        $carts = Cart::factory()->count(5)->create([
            'user_id' => $userId
        ]);

        $productId = $carts->first()->product_id;
        $originalQuantity = $carts->first()->quantity;

        $updatedCarts = $this->repository->update([
            'user_id' => $userId,
            'product_id' => $productId,
            'quantity' => 100
        ]);

        $this->assertDatabaseHas('carts', [
            'user_id' => $userId,
            'product_id' => $productId,
            'quantity' => 100
        ]);
    }
}