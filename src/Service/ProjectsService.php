<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\ProjectRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProjectsService
{
    public function __construct(private readonly ProjectRepository $projectRepository)
    {
    }

    public function handle(): array
    {
        if (null === $result = $this->projectRepository->findBy(['status' => '5'], ['title' => 'ASC'])) {
            throw new NotFoundHttpException();
        }

        return $result;
//        return [];
    }
}
