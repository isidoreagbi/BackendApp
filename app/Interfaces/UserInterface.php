<?php

namespace App\Interfaces;

interface UserInterface {
    public function createUser(array $data);
    public function getUserByEmail($email);
    public function updateUser($id, array $data);
}
