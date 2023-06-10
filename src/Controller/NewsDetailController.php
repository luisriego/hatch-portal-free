<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\SingleNewsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsDetailController extends AbstractController
{
    public function __construct(
        private readonly SingleNewsService $singleNewsService,
    ) {
    }

    #[Route('/news/{slug}', name: 'app_single_news')]
    public function __invoke(Request $request, $slug): Response
    {
        $news = $this->singleNewsService->handle($slug);

        return $this->render('news/news.base.html.twig',
            [
                'breadcrumb' => 'Blog',
                'news' => $news,
            ]);
    }
}
