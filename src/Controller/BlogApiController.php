<?php

declare(strict_types=1);

namespace App\Controller;

use App\Http\Response\ApiResponse;
use App\Service\SingleBlogService;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogApiController
{
    public function __construct(
        private readonly SingleBlogService $singleBlogService,
    ) {
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    #[Route('/api/blog/{id}', name: 'api_single_blog')]
    public function __invoke(string $id): ApiResponse
    {
        $blog = $this->singleBlogService->handle($id);

        return new ApiResponse($blog->toArray(), Response::HTTP_OK);
    }
}
