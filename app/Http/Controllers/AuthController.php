<?php

namespace App\Http\Controllers;

use App\Business\AuthManager;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function signIn(Request $request)
    {
        return view('auth.login');
    }

    public function signUp(Request $request)
    {
        return view('auth.register');
    }

    public function login(Request $request, AuthManager $authManager)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
            'remember_token' => 'nullable|in:true'
        ]);

        if (!array_key_exists('remember_token', $validated)) {
            $validated['remember_token'] = false;
        }

        $status = $authManager->login($validated);

        if (!$status) {
            return back()->with('message', 'Please check your login credentials...');
        }

        return redirect()->route('products')->with('message', 'Login Success...');
    }

    public function register(Request $request, AuthManager $authManager)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|max:15|confirmed',
        ]);

        $authManager->register($validated);

        return redirect()->route('signIn')->with('message', 'Success');
    }

    public function logout(Request $request, AuthManager $authManager)
    {
        $authManager->logout();

        return redirect()->route('products')->with('message', 'Success...');
    }
}
