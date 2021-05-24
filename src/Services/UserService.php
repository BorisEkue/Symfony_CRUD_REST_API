<?php

namespace App\Services; 

use App\Entity\User;
use App\Repository\UserRepositoryInterface;

class UserService implements UserServiceInterface
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
   public function getUser($id): User
   {
        $user = $this->userRepository->findById($id);
        return $user;
   }

   public function newUser(User $user): User
   {
        return $this->userRepository->save($user);
   }

   public function getAllUser()
   {
       $users = $this->userRepository->findAll();
   }

   public function deletUser(User $user): User
   {
    return $this->userRepository->delete($user);
   }

   public function updateUser(User $user)
   {
       return $this->userRepository->Update($user);
   }
}