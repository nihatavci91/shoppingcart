<?php

namespace App\Http\Controllers;

use App\Business\CartManager;
use App\Business\PaymentManager;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(CartManager $cartManager)
    {
        [$cart, $totalPrice] = $cartManager->getCart();
        $cart_quantity = count($cart);
        return view('checkout.index',[
            'cart' => $cart,
            'cart_quantity' => $cart_quantity,
            'total_price' => $totalPrice
        ]);
    }

    public function process(Request $request)
    {
       $data = $request->all();
        return (new PaymentService())->start($data)->getHtmlContent();
    }

    public function success(Request $request, PaymentManager $paymentManager)
    {

        $paymentManager->create($request->all());


        return view('checkout.success');
    }
}
