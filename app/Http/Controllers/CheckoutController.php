<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use App\Services\RedisCartService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = (new RedisCartService())->getCart();
        return view('checkout.index',['cart' => $cart]);
    }

    public function process(Request $request)
    {
        return (new PaymentService())->start()->getHtmlContent();
    }

    public function success(Request $request)
    {
        //kaydet
        dd($request);
        return view('welcome');
    }
}
