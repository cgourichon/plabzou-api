<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\User\StoreUserRequest;
use App\Http\Requests\API\User\UpdateUserRequest;
use App\Models\User;
use App\Services\User\UserService;

class UserController extends BaseController
{
    public function index()
    {
        $users = UserService::getUsers();

        return $this->success($users->toArray(), 'Utilisateurs récupérés avec succès.');
    }

    public function store(StoreUserRequest $request)
    {
        $user = UserService::createUser($request->validated());

        return $this->success($user->toArray(), 'Utilisateur créé avec succès.');
    }

    public function show(User $user)
    {
        $user->load(['administrativeEmployee', 'teacher', 'learner']);

        return $this->success($user->toArray(), 'Utilisateur récupéré avec succès.');
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user = UserService::updateUser($user, $request->validated());

        return $this->success($user->toArray(), 'Utilisateur mis à jour avec succès.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return $this->success($user->toArray(), 'Utilisateur supprimé avec succès.');
    }
}
