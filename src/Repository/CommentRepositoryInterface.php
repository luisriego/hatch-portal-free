<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Comment;

interface CommentRepositoryInterface
{
    public function save(Comment $entity, bool $flush = false): void;

    public function remove(Comment $entity, bool $flush = false): void;

    public function findOneByBlogEmailAndMessageOrFail(string $blog, string $email, string $message): ?Comment;

//    public function getTotalNumber(): ?int;
}
