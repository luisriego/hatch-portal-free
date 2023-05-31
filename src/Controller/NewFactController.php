<?php

namespace App\Controller;

use App\Entity\Fact;
use App\Form\FactFormType;
use App\Repository\FactRepository;
use App\Repository\FactRepositoryInterface;
use App\Repository\ProjectRepository;
use App\Repository\ProjectRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewFactController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ProjectRepositoryInterface $projectRepository,
        private readonly FactRepositoryInterface $factRepository,
    ) {
    }

    #[Route('/new-fact/{slug}', name: 'app_new_fact')]
    public function __invoke(Request $request, $slug): Response
    {
        $project = $this->projectRepository->findOneBySlugOrFail($slug);
        $facts = $this->factRepository->findAllByProjectIdOrFail($project->getId());
        $fact = new Fact();
        $form = $this->createForm(FactFormType::class, $fact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nextAction = $form->get('next')->isClicked() || 3 === count($facts)
                ? 'app_accept_conditions'
                : 'app_new_fact';

            if (null !== $form['name']->getData() and count($facts) < 3) {
                $fact->setProject($project);
                $project->setStatus(5);
                $project->markAsUpdated();

                $this->entityManager->persist($fact);
                $this->entityManager->flush();
            }

            return $this->redirectToRoute($nextAction, ['slug' => $project->getSlug()]);
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
