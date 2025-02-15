<?php

namespace App\Repositories;

use App\Model\User;

class UserRepository
{
    public function __construct()
    {
        //
    }

    public function getAll()
    {
        return User::with(['role', 'department', 'jobTitle'])->get();
    }
    
    public function find($id) {
        return User::findOrFail($id);
    }

    public function create(array $data) {
        return User::create($data);
    }

    public function update(User $user, array $data) {
        $user->update($data);
        return $user;
    }

    public function delete(User $user) {
        return $user->delete();
    }
}
