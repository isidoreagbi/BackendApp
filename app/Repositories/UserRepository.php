<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;

class UserRepository implements UserInterface {
    public function createUser(array $data) {
        return User::create($data);
    }

    public function getUserByEmail($email) {
        return User::where('email', $email)->first();
    }

    public function updateUser($id, array $data) {
        $user = User::find($id);
        $user->update($data);
        return $user;
    }
}

