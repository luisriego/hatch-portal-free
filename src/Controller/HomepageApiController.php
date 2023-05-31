<?php

namespace App\Controller;

use App\Http\Response\ApiResponse;
use App\Service\BlogService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageApiController
{
    public function __construct(
        private readonly BlogService $blogService,
    ) {
    }

    #[Route('/api/', name: 'api_homepage')]
    public function __invoke(): ApiResponse
    {
        $randomBlog = $this->blogService->handle();

        return new ApiResponse($randomBlog, Response::HTTP_OK);
    }
}
