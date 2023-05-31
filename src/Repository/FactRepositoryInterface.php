<?php

declare(strict_types=1);

namespace App\Repository;


use App\Entity\Fact;

interface FactRepositoryInterface
{
    public function save(Fact $entity, bool $flush = false): void;

    public function remove(Fact $entity, bool $flush = false): void;

    public function findAllByProjectIdOrFail(string $id): ?array;
}
