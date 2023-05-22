<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\CommentRepositoryInterface;

class CommentRepeatedService
{
    public function __construct(private readonly CommentRepositoryInterface $commentRepository)
    {
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    public function handle(string $id, string $email, string $message): bool
    {
        if (null === $this->commentRepository->findOneByBlogEmailAndMessageOrFail($id, $email, $message)) {
            return true;
        }

        return false;
    }
}
