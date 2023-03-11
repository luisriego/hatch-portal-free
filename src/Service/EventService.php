<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\EventRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EventService
{
    public function __construct(private readonly EventRepository $eventRepository)
    {
    }

    public function handle(): array|null
    {
//        if (null === $result = $this->eventRepository->findBy([], [], 1 )) {
//            throw new NotFoundHttpException();
//        }
        try {
            null === $result = $this->eventRepository->findBy([], [], 1 );
            return $result;
        }
        catch(\Exception $e){
            $errorMessage = $e->getMessage();
        }

        return null;
    }
}
