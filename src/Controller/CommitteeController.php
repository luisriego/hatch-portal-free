<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\AboutUsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommitteeController extends AbstractController
{
    public function __construct(
    ) {
    }

    #[Route('/our-committee', name: 'app_committee')]
    public function __invoke(): Response
    {
//        $randomData = $this->homepageService->handle();

        return $this->render('committee/committee.base.html.twig',
            [
                'breadcrumb' => 'Sobre nosso Comitê de Inovação',
//                'data' => $randomData
            ]);
    }
}
