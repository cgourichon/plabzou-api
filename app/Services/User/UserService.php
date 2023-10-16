<?php

namespace App\Services\User;

use App\Enums\StatusEnum;
use App\Models\Mode;
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

    private static function fillUser(User $user, array $data): void
    {
        if (isset($data['is_super_admin'])) {
            $user->administrativeEmployee()->updateOrCreate(['user_id' => $user->id], ['is_super_admin' => $data['is_super_admin']]);
        } else {
            $user->administrativeEmployee()->delete();
        }

        if (isset($data['teacher_status'])) {
            $user->teacher()->updateOrCreate(['user_id' => $user->id], ['status' => $data['teacher_status']]);
        } else {
            $user->teacher()->delete();
        }

        if (isset($data['learner_mode'])) {
            $user->learner()->updateOrCreate(['user_id' => $user->id], ['mode_id' => $data['learner_mode']]);
        } else {
            $user->learner()->delete();
        }
    }

    public static function createUser(array $data): User
    {
        $user = User::create(self::formatUserData($data));
        self::fillUser($user, $data);

        return $user;
    }

    public static function updateUser(User $user, array $data): User
    {
        $user->fill(self::formatUserData($data));
        self::fillUser($user, $data);
        $user->save();

        return $user;
    }

    public static function getTeacherStatuses(): array
    {
        return collect(StatusEnum::cases())->pluck('value')->toArray();
    }

    public static function getLearnerModes(): Collection
    {
        return Mode::all();
    }
}
