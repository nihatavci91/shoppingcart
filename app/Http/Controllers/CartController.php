<?php

namespace App\Http\Controllers;

use App\Business\CartManager;
use Illuminate\Http\Request;
use stdClass;

class CartController extends Controller
{
    public function index(Request $request, CartManager $cartManager)
    {
        [$cart, $totalPrice] = $cartManager->getCart();
        $cart_quantity = count($cart);
        return view('cart.index', [
            'cart' => $cart,
            'totalPrice' => $totalPrice,
            'cart_quantity' => $cart_quantity
        ]);
    }

    public function store(Request $request, CartManager $cartManager)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $cart = $cartManager->addToCart($validated['product_id']);

        return response()->json([
            'status' => 'success',
            'cart' => !empty($cart) ? $cart : new StdClass
        ]);
    }

    public function update(Request $request, CartManager $cartManager)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer'
        ]);

        $cartManager->updateQuantity($validated['product_id'], $validated['quantity']);

        return response()->json('success');
    }

    public function destroy(Request $request, CartManager $cartManager)
    {
        $cartManager->deleteCart();

        return redirect()->route('cart')->with('message', 'Cart Deleted...');
    }

    public function deleteProductFromCart(Request $request, CartManager $cartManager)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $cartManager->deleteProductFromCart($validated['product_id']);

        return response()->json('success');
    }

    public function applyCoupon(Request $request, CartManager $cartManager)
    {
        $status = $cartManager->applyCoupon($request->coupon);

        if (!$status) {
            return redirect()->route('cart')->with('message', 'Wrong Coupon...');
        }

        return redirect()->route('cart')->with('message', 'Coupon Applied...');
    }

    public function removeCoupon(Request $request, CartManager $cartManager)
    {
        $cartManager->removeCoupon($request->coupon);

        return redirect()->route('cart')->with('message', 'Coupon Removed...');
    }
}
