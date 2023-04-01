<?php

namespace App\Controller;

use App\Service\AboutUsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutUsController extends AbstractController
{
    public function __construct(
        private readonly AboutUsService $aboutUsService
    ) {
    }

    #[Route('/about-us', name: 'app_about_us')]
    public function __invoke(): Response
    {
//        $randomData = $this->homepageService->handle();

        return $this->render('about/about-us.base.html.twig',
            [
                'breadcrumb' => 'Sobre nossa Empresa',
//                'data' => $randomData
            ]);
    }
}
