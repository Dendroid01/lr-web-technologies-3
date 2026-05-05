<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    )
    {}

    public function showRegister()
    {
        return view('auth.register');
    }

    public function showLogin()
    {
        session()->save();
        return view('auth.login');
    }

    public function register(Request $request)
    {
        $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'login' => 'required|string|max:255|unique:users,login',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = $this->userService->register($request->all());
        Auth::login($user);

        return redirect()->route('home')->with('success', true);
    }


    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('login', $request->login)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->intended(route('home'));
        }

        return back()->withErrors(['error' => 'Неверный логин или пароль']);
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('home');
    }

    public function checkLogin(Request $request)
    {
        $login = trim($request->query('login'));

        $exists = User::where('login', $login)->exists();

        $xml = new \SimpleXMLElement('<response/>');
        $xml->addChild('available', $exists ? 'false' : 'true');

        return response($xml->asXML(), 200)
            ->header('Content-Type', 'application/xml');
    }
}
