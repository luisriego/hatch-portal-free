<?php

namespace App\Controller;

use App\Service\HomepageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    public function __construct(
        private readonly HomepageService $homepageService
    ) {
    }


    #[Route('/', name: 'app_homepage')]
    public function __invoke(): Response
    {
        $randomData = $this->homepageService->handle();

        return $this->render('homepage/index.html.twig',
            [
                'data' => $randomData,
            ]);
    }
}
