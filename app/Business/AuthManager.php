<?php
namespace App\Business;

use App\Handler\CartHandler;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\Auth;

class AuthManager
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(array $data): bool
    {
        $status = Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password']
        ],
            $data['remember_token']
        );


        if (!$status) {
            return false;
        }

        $cart = session('cart');

        if ($cart !== null) {
            $cartService = CartHandler::handler();

            $cartService->cartBulkInsert($cart);
            session()->forget('cart');
        }

        return true;
    }

    /**
     * @param array $data
     * @return User
     */
    public function register(array $data): User
    {
        $data['password'] = bcrypt($data['password']);

        $user = $this->userRepository->create($data);
        \auth()->login($user);
        $cart = session('cart');

        if ($cart !== null) {
            $cartService = CartHandler::handler();

            $cartService->cartBulkInsert($cart);
            session()->forget('cart');
        }

        return $user;

    }

    public function logout()
    {
        Auth::logout();
    }
}
