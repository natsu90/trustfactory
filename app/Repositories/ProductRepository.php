<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Support\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll(): Collection
    {
        return Product::all();
    }

    public function take(int $productId, int $quantity = 1): Product
    {
        $product = Product::find($productId);
        $product->decrement('stock_quantity', $quantity);
        $product->refresh();

        return $product;
    }

    public function return(int $productId, int $quantity = 1): Product
    {
        $product = Product::find($productId);
        $product->increment('stock_quantity', $quantity);
        $product->refresh();

        return $product;
    }
}