<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository
{
    protected Model $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function create(array $data) : User
    {
        return $this->model->create($data);
    }
}
