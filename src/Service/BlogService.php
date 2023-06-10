<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\BlogRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogService
{
    public function __construct(
        private readonly BlogRepositoryInterface $blogRepository
    ) {
    }

    public function handle(): array|null
    {
        if (null === $result = $this->blogRepository->findThreeActiveOrFail()) {
            return null;
//            throw new NotFoundHttpException();
        }

        return $result;
    }
}
