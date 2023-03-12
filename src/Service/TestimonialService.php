<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\BlogRepository;
use App\Repository\EventRepository;
use App\Repository\TestimonyRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TestimonialService
{
    public function __construct(private readonly TestimonyRepository $testimonyRepository)
    {
    }

    public function handle(): array|null
    {
        if (null === $result = $this->testimonyRepository->findBy([], [], 3 )) {
            throw new NotFoundHttpException();
        }

        return $result;
    }
}
