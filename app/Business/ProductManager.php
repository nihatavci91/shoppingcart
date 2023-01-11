<?php

namespace App\Business;

use App\Models\Product;
use App\Handler\CartHandler;
use App\Repository\ProductRepository;
use App\Services\CartServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class ProductManager
{
    protected ProductRepository $productRepository;
    protected CartServiceInterface $cartService;

    public function __construct(ProductRepository $productRepository)
    {
        $this->cartService = CartHandler::handler();
        $this->productRepository = $productRepository;
    }

    public function get()
    {
        $products = Cache::remember('products',1200 ,function () {
            return $this->productRepository->get([], ['paginate' => true]);
        });

        return [$products, $this->cartService->getCart()];
    }

    public function getById(int $productId) : Product
    {
        return $this->productRepository->getById($productId);
    }
}
