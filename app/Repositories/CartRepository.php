<?php

namespace App\Repositories;

use App\Interfaces\CartRepositoryInterface;
use App\Models\Cart;
use Illuminate\Support\Collection;

class CartRepository implements CartRepositoryInterface
{
    public function getAll(int $userId): Collection
    {
        return Cart::where('user_id', $userId)->get();
    }

    public function update(array $params): Cart
    {
        return Cart::updateOrCreate([
            'user_id' => $params['user_id'],
            'product_id' => $params['product_id']
        ],
        [
            'quantity' => $params['quantity']
        ]
        );
    }

    public function delete(array $params): bool
    {
        return Cart::where([
            'user_id' => $params['user_id'],
            'product_id' => $params['product_id']
        ])->delete();
    }
}