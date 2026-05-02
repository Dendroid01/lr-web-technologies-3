<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    private const ADMIN_LOGIN = 'admin';

    // Хеш от пароля "password123"
    private const ADMIN_PASSWORD_HASH = '$2y$12$EHBV3ZydkUII1tnkUhpjI.MHB1eH7YRHYijeyBi/UfzuQP00Zh3H2';

    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        if (
            $request->login === self::ADMIN_LOGIN &&
            Hash::check($request->password, self::ADMIN_PASSWORD_HASH)
        ) {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.visits');
        }

        return back()->withErrors(['error' => 'Неверный логин или пароль']);
    }

    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect()->route('admin.login');
    }
}
