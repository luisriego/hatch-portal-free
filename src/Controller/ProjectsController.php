<?php

namespace App\Controller;

use App\Service\ProjectsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectsController extends AbstractController
{
    public function __construct(
        private readonly ProjectsService $projectsService,
    ) {
    }

    #[Route('/projects', name: 'app_projects')]
    public function __invoke(): Response
    {
        $projects = $this->projectsService->handle();

        return $this->render('projects/all_projects.html.twig',
            [
                'breadcrumb' => 'Projetos candidatos',
                'projects' => $projects,
            ]);
    }
}
