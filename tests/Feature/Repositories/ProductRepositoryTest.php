<?php

namespace Tests\Feature\Repositories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Support\Collection;

class ProductRepositoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @var ProductRepositoryInterface
     */
    private $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->app->make(ProductRepositoryInterface::class);
    }

    public function testGetAll()
    {
        Product::factory()->count(10)->create();

        $products = $this->repository->getAll();

        $this->assertInstanceOf(Collection::class, $products);

        foreach ($products as $product)
            $this->assertInstanceOf(Product::class, $product);
    }

    public function testTakeStock()
    {
        $product = Product::factory()->create();
        $productId = $product->getKey();
        $originalQuantity = $product->stock_quantity;

        $updatedProduct = $this->repository->take($productId, 5);

        $this->assertInstanceOf(Product::class, $updatedProduct);
        $this->assertEquals($originalQuantity - 5, $updatedProduct->stock_quantity);
    }

    public function testReturnStock()
    {
        $product = Product::factory()->create();
        $productId = $product->getKey();
        $originalQuantity = $product->stock_quantity;

        $updatedProduct = $this->repository->return($productId, 5);

        $this->assertInstanceOf(Product::class, $updatedProduct);
        $this->assertEquals($originalQuantity + 5, $updatedProduct->stock_quantity);
    }
}