<?php

namespace App\Controller;

use App\Entity\Fact;
use App\Form\FactFormType;
use App\Repository\FactRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcceptConditionsController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ProjectRepository $projectRepository,
    ) {
    }

    #[Route('/accept/conditions/{projectId}', name: 'app_accept_conditions')]
    public function __invoke(Request $request, $projectId): Response
    {
        $project = $this->projectRepository->findOneBy(['id' => $projectId]);

        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('accept', SubmitType::class)
            ->add('reject', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            $accept_conditions = $form->get('accept')->isClicked();
            $nextAction = $form->get('accept')->isClicked()
                ? 'accept_conditions'
                : 'reject_conditions';

            if ($nextAction === 'accept_conditions') {
                $project->setIsAccepted(true);
                $project->SetAcceptedOn();
                $project->markAsUpdated();

                $this->entityManager->persist($project);
                $this->entityManager->flush();
            }

            if ($nextAction === 'reject_conditions') {
                $project->setIsAccepted(false);

                $this->entityManager->persist($project);
                $this->entityManager->flush();
            }

            return $this->redirectToRoute('app_homepage', ['projectId' => $project->getId()]);
        }
        return $this->render('accept_conditions/accept-conditions.html.twig', [
            'breadcrumb' => 'Condições para publicação e aceitação',
            'accept_form' => $form->createView(),
        ]);
    }
}
