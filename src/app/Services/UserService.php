<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function register(array $data): User
    {
        return User::create([
            'last_name'   => $data['last_name'],
            'first_name'  => $data['first_name'],
            'middle_name' => $data['middle_name'] ?? null,
            'name'        => $this->buildFullName($data),
            'email'       => $data['email'],
            'login'       => $data['login'],
            'password'    => Hash::make($data['password']),
        ]);
    }

    private function buildFullName(array $data): string
    {
        $middle = $data['middle_name'] ?? '';
        return trim("{$data['last_name']} {$data['first_name']} {$middle}");
    }
}
