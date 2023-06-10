<?php

namespace App\Controller;

use App\Entity\Highlight;
use App\Form\HighlightFormType;
use App\Repository\HighlightRepositoryInterface;
use App\Repository\ProjectRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewHighlightController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ProjectRepositoryInterface $projectRepository,
        private readonly HighlightRepositoryInterface $highlightRepository,
    ) {
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    #[Route('/new-highlight/{slug}', name: 'app_new_highlight')]
    public function __invoke(Request $request, $slug): Response
    {
        $project = $this->projectRepository->findOneBySlugOrFail($slug);
        $highlights = $this->highlightRepository->findAllByProjectIdOrFail($project->getId());
        $highlight = new Highlight();
        $form = $this->createForm(HighlightFormType::class, $highlight);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nextAction = $form->get('next')->isClicked()
                ? 'app_new_fact'
                : 'app_new_highlight';

            if (null !== $form['text']->getData()) {
                $highlight->setProject($project);
                $project->setStatus(4);
                $project->markAsUpdated();

                $this->entityManager->persist($highlight);
                $this->entityManager->flush();
            }

            return $this->redirectToRoute($nextAction, ['slug' => $project->getSlug()]);
        }

        return $this->render('new-highlight/new-highlight.html.twig',
            [
                'breadcrumb' => 'Novo Destaque',
                'highlights' => $highlights,
                'project_form' => $form->createView(),
                'project' => $project,
            ]);
    }
}
