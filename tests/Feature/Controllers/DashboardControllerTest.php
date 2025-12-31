<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;

class DashboardControllerTest extends TestCase
{
    public function testUpdateCart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->post('/cart/update', [
            'product_id' => $product->getKey(),
            'quantity' => 5
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->getKey(),
            'product_id' => $product->getKey(),
            'quantity' => 5
        ]);
    }

    public function testDeleteCart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        Cart::factory()->create([
            'user_id' => $user->getKey(),
            'product_id' => $product->getKey(),
        ]);

        $response = $this->actingAs($user)->post('/cart/delete', [
            'product_id' => $product->getKey()
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('carts', [
            'user_id' => $user->getKey(),
            'product_id' => $product->getKey()
        ]);
    }
}