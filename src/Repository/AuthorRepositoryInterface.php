<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Author;

interface AuthorRepositoryInterface
{
    public function save(Author $entity, bool $flush = false): void;

    public function remove(Author $entity, bool $flush = false): void;

    public function findOneByIdOrFail(string $id): ?Author;

    public function findOneByEmailOrFail(string $email): ?Author;
}
