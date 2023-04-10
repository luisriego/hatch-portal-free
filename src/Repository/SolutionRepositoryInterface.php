<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Solution;

interface SolutionRepositoryInterface
{
    public function save(Solution $entity, bool $flush = false): void;

    public function remove(Solution $entity, bool $flush = false): void;
}
