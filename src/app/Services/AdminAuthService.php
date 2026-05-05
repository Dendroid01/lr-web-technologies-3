<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;

class AdminAuthService
{
    public function attempt(string $login, string $password): bool
    {
        $adminLogin = config('admin.login');
        $adminHash = config('admin.password');

        if (!$adminHash) {
            throw new \RuntimeException('Admin password hash not configured');
        }

        return $login === $adminLogin && Hash::check($password, $adminHash);
    }
}
