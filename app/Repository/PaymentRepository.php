<?php
namespace App\Repository;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;

class PaymentRepository
{
    protected Model $model;

    public function __construct(Payment $model)
    {
        $this->model = $model;
    }

    public function create(array $data) : Payment
    {
        return $this->model->create($data);
    }
}
