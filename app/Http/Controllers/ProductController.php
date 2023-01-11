<?php

namespace App\Http\Controllers;

use App\Business\ProductManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request, ProductManager $productManager)
    {
        [$products, $cart] = $productManager->get();
        return view('products.index', [
            'products' => $products,
            'cart' => $cart
        ]);
    }
}
