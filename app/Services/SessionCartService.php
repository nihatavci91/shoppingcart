<?php

namespace App\Services;

use App\Models\Product;

class SessionCartService implements CartServiceInterface
{
    public function getCart(): array
    {
        $cart = session('cart');
        return $cart ?? [];
    }

    public function addToCart(Product $product): array
    {
        $cart = session('cart');

        if ($cart === null) {
            $cart = [];
        }

        if (array_key_exists('product:' . $product->id, $cart)) {
            $cart['product:' . $product->id]['quantity'] += 1;
            $this->cartBulkInsert($cart);
            return $cart;
        }

        $cart['product:' . $product->id] = [
            'productId' => $product->id,
            'quantity' => 1,
            'price' => $product->price,
            'image' => $product->image,
            'title' => $product->title
        ];

        $this->cartBulkInsert($cart);

        return $cart;
    }

    public function cartBulkInsert(array $cart): bool
    {
        session()->put('cart', $cart);

        return true;
    }

    public function updateQuantity($productId, $quantity): bool
    {
        $cart = session('cart');

        if ($cart === null || !array_key_exists('product:' . $productId, $cart)) {
            return false;
        }

        $cart['product:' . $productId]['quantity'] += $quantity;

        return true;
    }

    public function getProduct(int $productId): array
    {
        $cart = session('cart');

        if ($cart === null || !array_key_exists('product:' . $productId, $cart)) {
            return [];
        }

        return $cart['product:' . $productId];
    }

    public function removeProductFromCart($productId): bool
    {
        $cart = session('cart');

        if ($cart === null || !array_key_exists('product:' . $productId, $cart)) {
            return true;
        }

        unset($cart['product:' . $productId]);

        $this->cartBulkInsert($cart);

        return true;
    }

    public function emptyBasket(): bool
    {
        session()->forget('cart');

        return true;
    }
}
