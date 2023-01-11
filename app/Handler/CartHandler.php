<?php

namespace App\Handler;

use App\Services\CartServiceInterface;
use App\Services\RedisCartService;
use App\Services\SessionCartService;

class CartHandler
{
    public static function handler() : CartServiceInterface
    {
        return auth()->check() ? new RedisCartService() : new SessionCartService();
    }
}
