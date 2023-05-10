<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\News;
use App\Repository\NewsRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SingleNewsService
{
    public function __construct(private readonly NewsRepositoryInterface $newsRepo)
    {
    }

    public function handle(string $slug): News|null
    {
        if (null === $result = $this->newsRepo->findOneBySlugOrFail($slug)) {
            throw new NotFoundHttpException();
        }

        return $result;
    }
}
