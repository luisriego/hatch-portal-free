<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EthicController extends AbstractController
{
    public function __construct(
    ) {
    }

    #[Route('/ethic', name: 'app_ethic')]
    public function __invoke(): Response
    {
        return $this->render('about/ethic.html.twig',
            [
                'breadcrumb' => 'Sobre a nossa companhia',
            ]);
    }
}
