<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\BlogRepositoryInterface;

class BlogsService
{
    public function __construct(private readonly BlogRepositoryInterface $blogRepository)
    {
    }

    public function handle(): array
    {
        return $this->blogRepository->getAllPostsActives();
    }
}
