<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ChallengeLaunched;

interface ChallengeLaunchedRepositoryInterface
{
    public function save(ChallengeLaunched $entity, bool $flush = false): void;

    public function remove(ChallengeLaunched $entity, bool $flush = false): void;

    public function findOneBySlugOrFail(string $slug): ?ChallengeLaunched;

    public function getTotalNumber(): ?int;

    public function getAllChallengesLaunchedActives(): ?array;
}
