<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\NewsRepository;

class NewsService
{
    public function __construct(private readonly NewsRepository $newsRepository)
    {
    }

    public function handle(): array|null
    {
//        if (null === $result = $this->newsRepository->findBy(['toPublish' => true], [], 3 )) {
//            throw new NotFoundHttpException();
//        }
        try {
            null === $result = $this->newsRepository->findBy(['toPublish' => true], [], 3 );
            return $result;
        }
        catch(\Exception $e){
            $errorMessage = $e->getMessage();
        }

        return null;
    }
}
