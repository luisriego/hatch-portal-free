<?php

namespace App\Controller;

use App\Repository\NewsRepositoryInterface;
use App\Service\BlogService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    public function __construct(
        private readonly BlogService $blogService,
        private readonly NewsRepositoryInterface $newsRepository,
    ) {
    }

    #[Route('/', name: 'app_homepage')]
    public function __invoke(): Response
    {
        $randomBlog = $this->blogService->handle();
        $randomNews = $this->newsRepository->findNActiveOrFail(3);

        return $this->render('homepage/index.html.twig',
            [
                'blogs' => $randomBlog,
                'news' => $randomNews,
                'challenges' => [],
            ]);
    }
}
