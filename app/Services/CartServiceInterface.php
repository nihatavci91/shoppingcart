<?php

namespace App\Services;

use App\Models\Product;

interface CartServiceInterface
{
    public function getCart(): array;

    public function cartBulkInsert(array $cart): bool;

    public function addToCart(Product $product): array;

    public function updateQuantity($productId, $quantity): bool;

    public function getProduct(int $productId): array;

    public function removeProductFromCart($productId): bool;

    public function emptyBasket(): bool;
}
