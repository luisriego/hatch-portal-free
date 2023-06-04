<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\ChallengeLaunchedRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ChallengeLaunchedService
{
    public function __construct(private readonly ChallengeLaunchedRepositoryInterface $challengeLaunchedRepository)
    {
    }

    public function handle(): array|null
    {
        if (null === $result = $this->challengeLaunchedRepository->getAllChallengesLaunchedActives()) {
            throw new NotFoundHttpException();
        }

        return $result;
    }
}
