<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\News;

interface NewsRepositoryInterface
{
    public function save(News $entity, bool $flush = false): void;

    public function remove(News $entity, bool $flush = false): void;

    public function findOneByIdOrFail(string $id): ?News;

    public function findOneBySlugOrFail(string $slug): ?News;

    public function findNActiveOrFail(int $limit): ?array;

    public function getTotalNumber(): ?int;

    public function getAllNewsActives(int $maxResults): ?array;
}
