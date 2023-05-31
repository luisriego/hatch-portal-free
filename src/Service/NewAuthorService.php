<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Author;
use App\Repository\AuthorRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NewAuthorService
{
    public function __construct(private readonly AuthorRepositoryInterface $authorRepository)
    {
    }

    public function handle(string $email): Author|null
    {
        if (null === $result = $this->authorRepository->findOneByEmailOrFail($email)) {
            throw new NotFoundHttpException();
        }

        return $result;
    }
}
