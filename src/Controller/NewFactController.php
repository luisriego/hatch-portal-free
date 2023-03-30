<?php

namespace App\Controller;

use App\Entity\Fact;
use App\Form\FactFormType;
use App\Repository\FactRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewFactController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ProjectRepository $projectRepository,
        private readonly FactRepository $factRepository,
    ) {
    }

    #[Route('/new-fact/{projectId}', name: 'app_new_fact')]
    public function __invoke(Request $request, $projectId): Response
    {
        $project = $this->projectRepository->findOneBy(['id' => $projectId]);
        $facts = $this->factRepository->findBy(['project' => $projectId]);
        $fact = new Fact();
        $form = $this->createForm(FactFormType::class, $fact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nextAction = $form->get('next')->isClicked()
                ? 'app_homepage'
                : 'app_new_fact';

            if (null !== $form['name']->getData()) {
                $fact->setProject($project);
                $project->setStatus(5);

                $this->entityManager->persist($fact);
                $this->entityManager->flush();
            }

            return $this->redirectToRoute($nextAction, ['projectId' => $project->getId()]);
        }

        return $this->render('new-fact/new-fact.html.twig',
            [
                'breadcrumb' => 'Adicionar Fato',
                'facts' => $facts,
                'project_form' => $form->createView(),
                'project' => $project,
            ]);
    }
}
