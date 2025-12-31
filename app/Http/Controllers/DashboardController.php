<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\CartRepositoryInterface;
use App\Http\Requests\UpdateCartRequest;
use App\Http\Requests\DeleteCartRequest;

class DashboardController extends Controller
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository,
        protected CartRepositoryInterface $cartRepository
    ){}

    /**
     * Main Dashboard page
     */
    public function index(Request $request)
    {
        $products = $this->productRepository->getAll();
        $userId = $request->user()->getKey();
        $carts = $this->cartRepository->getAll($userId);

        return Inertia::render('Dashboard', [
            'products' => $products,
            'carts' => $carts
        ]);
    }

    /**
     * Add or Update Cart
     */
    public function updateCart(UpdateCartRequest $request)
    {
        $params = $request->validated();
        $this->cartRepository->update($params);

        return Redirect::back()->with('success', 'Cart updated successfully');
    }

    /**
     * Remove Product from Cart
     */
    public function deleteCart(DeleteCartRequest $request)
    {
        $params = $request->validated();
        $this->cartRepository->delete($params);

        return Redirect::back()->with('success', 'Item removed from cart');
    }
}