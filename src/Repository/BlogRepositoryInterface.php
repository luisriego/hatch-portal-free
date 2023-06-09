<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Blog;

interface BlogRepositoryInterface
{
    public function save(Blog $entity, bool $flush = false): void;

    public function remove(Blog $entity, bool $flush = false): void;

    public function findOneByIdOrFail(string $id): ?Blog;

    public function findOneBySlugOrFail(string $slug): ?Blog;

    public function findThreeActiveOrFail(int $limit): ?array;

    public function getTotalNumber(): ?int;

    public function getAllPostsActives(): ?array;
}
