<?php

namespace App\Controller;

use App\Service\NewsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChallengeSetController extends AbstractController
{
    public function __construct(
        private readonly NewsService $newsService,
    ) {
    }

    #[Route('/challenges-set', name: 'app_challenges')]
    public function __invoke(): Response
    {
        // $news = $this->newsService->handle();

        return $this->render('challenge-set/all_challenges_set.html.twig',
            [
                'breadcrumb' => 'Desafios lançados por colegas da Hatch Brasil',
                'challengesSet' => [],
            ]);
    }
}
