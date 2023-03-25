<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Form\ChallengeFormType;
use App\Repository\ChallengeRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewChallengeController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ProjectRepository $projectRepository,
        private readonly ChallengeRepository $challengeRepository,
    )
    {
    }

    #[Route('/new-challenge/{projectId}', name: 'app_new_challenge')]
    public function __invoke(Request $request, $projectId): Response
    {
        $project = $this->projectRepository->findOneBy(['id' => $projectId]);
        $challenges = $this->challengeRepository->findBy(['project' => $projectId]);
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

                $this->entityManager->persist($challenge);
                $this->entityManager->flush();
            }

            return $this->redirectToRoute($nextAction, ['projectId' => $project->getId()]);
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
