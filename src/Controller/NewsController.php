<?php

namespace App\Controller;

use App\Service\NewsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    public function __construct(
        private readonly NewsService $newsService,
    ) {
    }

    #[Route('/news', name: 'app_news')]
    public function __invoke(): Response
    {
        $news = $this->newsService->handle();

        return $this->render('posts/all_news.html.twig',
            [
                'breadcrumb' => 'Notícias de atualidade sobre inovação e tecnologia',
                'news' => $news,
            ]);
    }
}
