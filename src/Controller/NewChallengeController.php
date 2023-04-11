<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Form\ChallengeFormType;
use App\Repository\ChallengeRepository;
use App\Repository\ProjectRepository;
use App\Repository\ProjectRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewChallengeController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ProjectRepositoryInterface $projectRepository,
        private readonly ChallengeRepository $challengeRepository,
    ) {
    }

    #[Route('/new-challenge/{slug}', name: 'app_new_challenge')]
    public function __invoke(Request $request, $slug): Response
    {
        $project = $this->projectRepository->findOneBySlugOrFail($slug);
        $challenges = $this->challengeRepository->findBy(['project' => $project->getId()]);
        $challenge = new Challenge();
        $form = $this->createForm(ChallengeFormType::class, $challenge);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nextAction = $form->get('next')->isClicked()
                ? 'app_new_solution'
                : 'app_new_challenge';

            if (null !== $form['text']->getData()) {
                $challenge->setProject($project);
                $project->setStatus(2);
                $project->markAsUpdated();

                $this->entityManager->persist($challenge);
                $this->entityManager->flush();
            }

            return $this->redirectToRoute($nextAction, ['slug' => $project->getSlug()]);
        }

        return $this->render('new-challenge/new-challenge.html.twig',
            [
                'breadcrumb' => 'Add Challenge',
                'challenges' => $challenges,
                'project_form' => $form->createView(),
                'project' => $project,
            ]);
    }
}
