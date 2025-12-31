<?php

namespace App\Interfaces;

use App\Models\Cart;
use Illuminate\Support\Collection;

interface CartRepositoryInterface
{
    /**
     * Get all items in Cart by User ID
     */
    public function getAll(int $userId): Collection;

    /**
     * Update Cart
     */
    public function update(array $params): Cart;

    /**
     * Remove Product from Cart
     */
    public function delete(array $params): bool;
}