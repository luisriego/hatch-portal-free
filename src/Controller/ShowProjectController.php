<?php

namespace App\Controller;

use App\Service\SingleProjectService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowProjectController extends AbstractController
{
    public function __construct(
        private readonly SingleProjectService $projectsService,
    ) {
    }

    #[Route('/project/{slug}', name: 'app_project')]
    public function __invoke(Request $request, $slug): Response
    {
        $project = $this->projectsService->handle($slug);

        return $this->render('projects/single.project.base.html.twig',
            [
                'breadcrumb' => $project->getTitle(),
                'project' => $project,
            ]);
    }
}
