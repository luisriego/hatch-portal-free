<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\BlogRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogService
{
    public function __construct(private readonly BlogRepository $blogRepository)
    {
    }

    public function handle(): array|null
    {
        if (null === $result = $this->blogRepository->findBy([], [], 3)) {
            throw new NotFoundHttpException();
        }

        return $result;
    }
}
