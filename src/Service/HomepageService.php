<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\DoctrineTopicRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HomepageService
{
    public function __construct(private readonly DoctrineTopicRepository $topicRepository)
    {
    }

    public function handle(): array
    {
        if (null === $result = $this->topicRepository->findBy(['toPublish' => true], ['type' => 'ASC'], 3 )) {
            throw new NotFoundHttpException();
        }

        return $result;
//        return [];
    }
}
