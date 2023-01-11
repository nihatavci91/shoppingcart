<?php

namespace App\Repository;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository
{
    protected Model $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function get(array $filters = [], array $options = []) : LengthAwarePaginator
    {
        $query = $this->model;

        if (array_key_exists('title', $filters)) {
            $query = $query->where('title', $filters['title']);
        }

        if (array_key_exists('price', $filters)) {
            $query = $query->where('price', $filters['price']);
        }

        if (array_key_exists('paginate', $options)) {
            return $query->paginate(15);
        }

        return $query->get();
    }

    public function getById(int $productId) : Product
    {
        return $this->model->find($productId);
    }
}
