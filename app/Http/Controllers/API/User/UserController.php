<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\User\CurrentUserRequest;
use App\Http\Requests\API\User\UserRequest;
use App\Models\User;
use App\Services\User\UserService;

class UserController extends BaseController
{
    public function index()
    {
        $users = UserService::getUsers();

        return $this->success($users->toArray(), 'Utilisateurs récupérés avec succès.');
    }

    public function store(UserRequest $request)
    {
        $user = UserService::createUser($request->validated());

        return $this->success($user->toArray(), 'Utilisateur créé avec succès.');
    }

    public function show(User $user)
    {
        $user->load(['administrativeEmployee', 'teacher', 'learner.mode']);

        return $this->success($user->toArray(), 'Utilisateur récupéré avec succès.');
    }

    public function update(UserRequest $request, User $user)
    {
        $user->load(['administrativeEmployee', 'teacher', 'learner']);

        $user = UserService::updateUser($user, $request->validated());

        return $this->success($user->toArray(), 'Utilisateur mis à jour avec succès.');
    }

    public function updateCurrent(CurrentUserRequest $request)
    {
        return $this->success(
            UserService::updateCurrentUSer($request->only('phone_number', 'password'))->toArray(),
            'Profil mis à jour avec succès.'
        );
    }


    public function destroy(User $user)
    {
        $user->delete();

        return $this->success([], 'Utilisateur supprimé avec succès.');
    }
}
