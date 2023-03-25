<?php

declare(strict_types=1);

namespace App\Service\admin;

use App\Repository\ProjectRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProjectAdminService
{
    public function __construct(private readonly ProjectRepository $projectRepository)
    {
    }

    public function handle(): array|null
    {
        if (null === $result = $this->projectRepository->findBy(['status' => 5])) {
            throw new NotFoundHttpException();
        }

        return $result;
    }
}
