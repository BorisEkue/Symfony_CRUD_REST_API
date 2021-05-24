<?php

namespace App\Repository;

use App\Entity\User;

interface UserRepositoryInterface
{
    public function findById(string $id);

    public function save(User $user): User;
    
    public function findAll();

    public function delete(User $user): User;

    public function update(User $user);
}