<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SingleProjectService
{
    public function __construct(private readonly ProjectRepository $projectRepository)
    {
    }

    public function handle(string $slug): Project|null
    {
        if (null === $result = $this->projectRepository->findOneBy(['slug' => $slug])) {
            throw new NotFoundHttpException();
        }

        return $result;
    }
}
