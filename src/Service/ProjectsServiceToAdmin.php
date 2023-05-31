<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\ProjectRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProjectsServiceToAdmin
{
    public function __construct(private readonly ProjectRepositoryInterface $projectRepository)
    {
    }

    public function handle(): array
    {
        if (null === $result = $this->projectRepository->getAllProjectsToAdmin()) {
            throw new NotFoundHttpException();
        }

        return $result;
    }
}
