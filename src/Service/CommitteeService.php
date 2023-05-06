<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\DoctrineTopicRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommitteeService
{
    public function __construct(private readonly DoctrineTopicRepository $topicRepository)
    {
    }

    public function handle(): array
    {
        if (null === $result = $this->topicRepository->findRandomTreeOrFail()) {
            throw new NotFoundHttpException();
        }

        return $result;
    }
}
