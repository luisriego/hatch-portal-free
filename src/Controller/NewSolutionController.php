<?php

namespace App\Controller;

use App\Entity\Solution;
use App\Form\SolutionFormType;
use App\Repository\ProjectRepository;
use App\Repository\SolutionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewSolutionController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ProjectRepository $projectRepository,
        private readonly SolutionRepository $solutionRepository,
    ) {
    }

    #[Route('/new-solution/{projectId}', name: 'app_new_solution')]
    public function __invoke(Request $request, $projectId): Response
    {
        $project = $this->projectRepository->findOneBy(['id' => $projectId]);
        $solutions = $this->solutionRepository->findBy(['project' => $projectId]);
        $solution = new Solution();
        $form = $this->createForm(SolutionFormType::class, $solution);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nextAction = $form->get('next')->isClicked()
                ? 'app_new_highlight'
                : 'app_new_solution';

            if (null !== $form['text']->getData()) {
                $solution->setProject($project);
                $project->setStatus(3);
                $project->markAsUpdated();

                $this->entityManager->persist($solution);
                $this->entityManager->flush();
            }

            return $this->redirectToRoute($nextAction, ['projectId' => $project->getId()]);
        }

        return $this->render('new-solution/new-solution.html.twig',
            [
                'breadcrumb' => 'Nova Solução',
                'solutions' => $solutions,
                'project_form' => $form->createView(),
                'project' => $project,
            ]);
    }
}
