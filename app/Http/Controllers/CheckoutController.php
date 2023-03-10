<?php

namespace App\Http\Controllers;

use App\Business\CartManager;
use App\Business\PaymentManager;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(CartManager $cartManager)
    {
        $this->cartManager = $cartManager;
    }

    public function index()
    {
        [$cart, $totalPrice] = $this->cartManager->getCart();
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
        auth()->login(User::find($request['user_id']));
        $this->cartManager->deleteCart();
        return view('checkout.success');
    }
}
