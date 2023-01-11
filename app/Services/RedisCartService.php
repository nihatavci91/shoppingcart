<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Redis;

class RedisCartService implements CartServiceInterface
{

    public function cartKey(): string
    {
        return "shop:{" . auth()->id() . "}:cart";
    }

    public function productKey($productId): string
    {
        return "product:" . $productId;
    }

    public function decodeArray(string $object): array
    {
        return json_decode($object, true);
    }

    public function encodeArray(array $array): string
    {
        return json_encode($array);
    }

    public function getCart(): array
    {
        $cart = Redis::hgetall($this->cartKey());

        if ($cart === null) {
            return [];
        }

        foreach ($cart as $key => $value) {
            $cart[$key] = $this->decodeArray($value);
        }

        return $cart;
    }

    public function addToCart(Product $product): array
    {
        $cart = $this->getCart();

        if (array_key_exists($this->productKey($product->id), $cart)) {
            $cart[$this->productKey($product->id)]['quantity'] += 1;

            $this->cartBulkInsert($cart);

            return $cart;
        }

        $productArray = [
            'productId' => $product->id,
            'quantity' => 1,
            'price' => $product->price,
            'image' => $product->image,
            'title' => $product->title
        ];

        Redis::hmset($this->cartKey(), $this->productKey($product->id), $this->encodeArray($productArray));

        return $this->getCart();
    }

    public function cartBulkInsert(array $cart): bool
    {
        foreach ($cart as $key => $value) {
            Redis::hmset($this->cartKey(), $key, $this->encodeArray($value));
        }

        return true;
    }

    public function updateQuantity($productId, $quantity): bool
    {
        $cartProduct = $this->getProduct($productId);

        $cartProduct['quantity'] += $quantity;

        Redis::hmset($this->cartKey(), $this->productKey($productId), $this->encodeArray($cartProduct));

        return true;
    }

    public function getProduct(int $productId): array
    {
        $object = Redis::hget($this->cartKey(), $this->productKey($productId));
        return $this->decodeArray($object);
    }

    public function removeProductFromCart($productId): bool
    {
        Redis::hdel($this->cartKey(), $this->productKey($productId));

        return true;
    }

    public function emptyBasket(): bool
    {
        $cart = Redis::hgetall($this->cartKey());

        if ($cart === null) {
            return true;
        }

        foreach ($cart as $key => $value) {
            Redis::hdel($this->cartKey(), $key);
        }

        return true;
    }
}
