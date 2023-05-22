<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\ProjectRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeleteProjectsService
{
    public function __construct(private readonly ProjectRepositoryInterface $projectRepository)
    {
    }

    public function handle(string $slug): void
    {
        if (null === $result = $this->projectRepository->findOneBySlugOrFail($slug)) {
            throw new NotFoundHttpException();
        }

        $this->projectRepository->remove($result, true);
    }
}
