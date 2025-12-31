<?php

namespace App\Interfaces;

use App\Models\Product;
use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    /**
     * Get all Product
     */
    public function getAll(): Collection;

    /**
     * Deduce stock quantity
     */
    public function take(int $productId, int $quantity): Product;

    /**
     * Return stock quantity
     */
    public function return(int $productId, int $quantity): Product;
}