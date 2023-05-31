<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Project;

interface ProjectRepositoryInterface
{
    public function save(Project $entity, bool $flush = false): void;

    public function remove(Project $entity, bool $flush = false): void;

    public function findOneBySlugOrFail(string $slug): ?Project;

    public function findOneByTitleAndAreaOrFail(string $title, string $area): ?Project;

    public function getTotalNumber(): ?int;

    public function getAllProjectsToAdmin(): ?array;
}
