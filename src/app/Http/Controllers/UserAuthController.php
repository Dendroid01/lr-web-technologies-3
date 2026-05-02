<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'last_name'             => 'required|string|max:255',
            'first_name'            => 'required|string|max:255',
            'middle_name'           => 'nullable|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'login'                 => 'required|string|max:255|unique:users,login',
            'password'              => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'        => trim("{$request->last_name} {$request->first_name} " . ($request->middle_name ?? '')),
            'last_name'   => $request->last_name,
            'first_name'  => $request->first_name,
            'middle_name' => $request->middle_name,
            'email'       => $request->email,
            'login'       => $request->login,
            'password'    => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', true);
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
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
