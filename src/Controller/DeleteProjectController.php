<?php

namespace App\Controller;

use App\Service\DeleteProjectsService;
use App\Service\ProjectsServiceToAdmin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteProjectController extends AbstractController
{
    public function __construct(
        private readonly DeleteProjectsService $deleteProjectService,
        private readonly ProjectsServiceToAdmin $projectsServiceToAdmin,
    ) {
    }

    #[Route('/project/delete/{slug}', name: 'app_delete_project')]
    public function __invoke(string $slug): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $this->deleteProjectService->handle($slug);
            $projects = $this->projectsServiceToAdmin->handle();
        }

        return $this->render('projects/all_projects.html.twig',
            [
                'breadcrumb' => 'Projetos candidatos',
                'projects' => $projects,
            ]);
    }
}
