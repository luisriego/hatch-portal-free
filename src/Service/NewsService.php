<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\NewsRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NewsService
{
    public function __construct(private readonly NewsRepository $newsRepository)
    {
    }

    public function handle(): array
    {
        if (null === $result = $this->newsRepository->findBy(['toPublish' => true], [], 3 )) {
            throw new NotFoundHttpException();
        }

        return $result;
    }
}
