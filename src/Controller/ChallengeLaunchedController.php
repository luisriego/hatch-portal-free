<?php

namespace App\Controller;

use App\Service\ChallengeLaunchedService;
use App\Service\NewsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChallengeLaunchedController extends AbstractController
{
    public function __construct(
        private readonly ChallengeLaunchedService $challengeLaunchedService,
    ) {
    }

    #[Route('/challenges_launched', name: 'app_challenge_launched')]
    public function __invoke(): Response
    {
        $challengesLaunched = $this->challengeLaunchedService->handle();

        return $this->render('challenge-launched/all_challenges_lauched.html.twig',
            [
                'breadcrumb' => 'Dasafios internos lançados por colaboradores',
                'challengesLaunched' => $challengesLaunched,
            ]);
    }
}
