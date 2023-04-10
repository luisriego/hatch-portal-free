<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Challenge;

interface ChallengeRepositoryInterface
{
    public function save(Challenge $entity, bool $flush = false): void;

    public function remove(Challenge $entity, bool $flush = false): void;

    public function findOneBySlugOrFail(string $slug): ?Challenge;
}
