<?php

namespace App\Controller;

use App\Service\BlogsService;
use App\Service\ProjectsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostsController extends AbstractController
{
    public function __construct(
        private readonly BlogsService $blogsService,
    ) {
    }

    #[Route('/posts', name: 'app_posts')]
    public function __invoke(): Response
    {
        $posts = $this->blogsService->handle();

        return $this->render('posts/all_posts.html.twig',
            [
                'breadcrumb' => 'Nosso blog',
                'posts' => $posts,
            ]);
    }
}
