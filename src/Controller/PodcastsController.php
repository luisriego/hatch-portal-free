<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PodcastsController extends AbstractController
{
    public function __construct(
    ) {
    }

    #[Route('/podcasts', name: 'app_podcasts')]
    public function __invoke(): Response
    {
        return $this->render('podcasts/podcasts.html.twig',
            [
                'breadcrumb' => 'Podcasts',
            ]);
    }
}
