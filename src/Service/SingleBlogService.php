<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Blog;
use App\Repository\BlogRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SingleBlogService
{
    public function __construct(private readonly BlogRepositoryInterface $blogRepository)
    {
    }

    public function handle(string $slug): Blog|null
    {
        if (null === $result = $this->blogRepository->findOneBySlugOrFail($slug)) {
            throw new NotFoundHttpException();
        }

        return $result;
    }
}
