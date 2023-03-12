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

    public function handle(): array|null
    {
//        if (null === $result = $this->newsRepository->findRandom3withSQL()) {
//            throw new NotFoundHttpException();
//        }
//        dd($result);
        try {
//            null === $result = $this->newsRepository->findBy(['toPublish' => true], [], 3 );
            null === $result = $this->newsRepository->findRandom3withSQL();

            return $result;
        }
        catch(\Exception $e){
            $errorMessage = $e->getMessage();
        }

        return null;
    }
}
