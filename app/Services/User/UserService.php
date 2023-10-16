<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Collection;

class UserService
{
    public static function getUsers(): Collection
    {
        return User::with(['administrativeEmployee', 'teacher', 'learner'])->get();
    }

    private static function formatUserData(array $data): array
    {
        $data['first_name'] = ucwords(strtolower($data['first_name']));
        $data['last_name'] = strtoupper($data['last_name']);
        $data['email'] = strtolower($data['email']);

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        return $data;
    }

    public static function createUser(array $data): User
    {
        return User::create(self::formatUserData($data));
    }

    public static function updateUser(User $user, array $data): User
    {
        $user->fill(self::formatUserData($data));
        $user->save();

        return $user;
    }
}
