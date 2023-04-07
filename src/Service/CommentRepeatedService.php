<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Blog;
use App\Entity\Comment;
use App\Repository\BlogRepository;
use App\Repository\CommentRepositoryInterface;
use App\Repository\DoctrineCommentRepository;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
            return false;
        }

        return true;
    }
}
