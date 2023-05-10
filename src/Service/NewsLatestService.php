<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\NewsRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NewsLatestService
{
    public function __construct(private readonly NewsRepository $newsRepository)
    {
    }

    public function handle(): array|null
    {
        if (null === $result = $this->newsRepository->findNActiveOrFail(3)) {
            throw new NotFoundHttpException();
        }

        return $result;
    }
}
