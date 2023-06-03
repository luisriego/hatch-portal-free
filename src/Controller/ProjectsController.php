<?php

namespace App\Controller;

use App\Service\ProjectsService;
use App\Service\ProjectsServiceToAdmin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectsController extends AbstractController
{
    public function __construct(
        private readonly ProjectsService $projectsService,
        private readonly ProjectsServiceToAdmin $projectsServiceToAdmin,
    ) {
    }

    #[Route('/projects', name: 'app_projects')]
    public function __invoke(): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $projects = $this->projectsServiceToAdmin->handle();
        } else {
            $projects = $this->projectsService->handle();
        }

        return $this->render('projects/all_projects.html.twig',
            [
                'breadcrumb' => 'Projetos candidatos',
                'projects' => $projects,
            ]);
    }
}
