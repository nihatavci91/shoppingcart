<?php

namespace App\Business;

use App\Handler\CartHandler;
use App\Repository\CouponRepository;
use App\Services\CartServiceInterface;

class CartManager
{
    protected ProductManager $productManager;
    protected CartServiceInterface $cartService;
    protected CouponRepository $couponRepository;

    public function __construct(ProductManager $productManager, CouponRepository $couponRepository)
    {
        $this->cartService = CartHandler::handler();
        $this->productManager = $productManager;
        $this->couponRepository = $couponRepository;
    }

    public function getCart()
    {
        $cart = $this->cartService->getCart();

        $totalPrice = 0;

        foreach ($cart as $value) {
            $totalPrice += ($value['quantity'] * $value['price']);
        }

        if (session()->has('coupon')) {
            $coupon = session('coupon');

            $discount = $totalPrice * ($coupon['discount'] / 100);
            $totalPrice -= $discount;
        }

        return [$cart, $totalPrice];
    }

    public function addToCart(int $productId)
    {
        $product = $this->productManager->getById($productId);

        return $this->cartService->addToCart($product);
    }

    public function updateQuantity($productId, $quantity)
    {
        $this->cartService->updateQuantity($productId, $quantity);
    }

    public function deleteProductFromCart($productId)
    {
        $this->cartService->removeProductFromCart($productId);
    }

    public function deleteCart()
    {
        $this->cartService->emptyBasket();
    }

    public function applyCoupon($code)
    {
        $coupon = $this->couponRepository->getByCode($code);

        if ($coupon === null) {
            return false;
        }

        session()->put('coupon', [
            'code' => $coupon->code,
            'discount' => $coupon->discount
        ]);

        return true;
    }

    public function removeCoupon($code)
    {
        session()->forget('coupon');

        return true;
    }
}
