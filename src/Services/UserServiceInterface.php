<?php

namespace App\Services;

use App\Entity\User;

interface UserServiceInterface
{
    public function getUser($id): User;

    public function newUser(User $user): User;

    public function getAllUser();

    public function deletUser(User $user): User;

    public function updateUser(User $user);
}