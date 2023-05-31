<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Highlight;

interface HighlightRepositoryInterface
{
    public function save(Highlight $entity, bool $flush = false): void;

    public function remove(Highlight $entity, bool $flush = false): void;

    public function findAllByProjectIdOrFail(string $id): ?array;
}
