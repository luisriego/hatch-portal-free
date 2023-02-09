<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\User;
use App\Exception\UserAlreadyExistsException;
use App\Repository\UserRepository;
use App\Service\Security\PasswordHasherInterface;

class CreateUserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly PasswordHasherInterface $passwordHasher
    ) {
    }

    public function create(string $email, string $password): array
    {
        /*
         * CASE_1: Case for repository method without exception
         */
        if (null !== $this->userRepository->findOneByEmail($email)) {
            throw UserAlreadyExistsException::createFromEmail($email);
        }

        $user = new User();
        $user->setEmail($email);
        $password = $this->passwordHasher->hashPasswordForUser($user, $password);
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);

        $this->userRepository->save($user);

        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
        ];
    }
}