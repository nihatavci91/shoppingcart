<?php

namespace App\Repository;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Model;

class CouponRepository
{
    protected Model $model;

    public function __construct(Coupon $model)
    {
        $this->model = $model;
    }

    public function getByCode(string $code) : ?Coupon
    {
        return $this->model->where('code', $code)->first();
    }
}
