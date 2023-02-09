<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function remove(User $user): void;

    public function findOneByEmail(string $email): ?User;

    public function findOneByEmailOrFail(string $email): User;

    public function findOneByIdOrFail(string $id): User;
}
