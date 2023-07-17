<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Form\ChallengeFormType;
use App\Repository\AuthorRepositoryInterface;
use App\Service\UploadFileService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewChallengeSetController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly AuthorRepositoryInterface $authorRepository,
        private readonly UploadFileService $uploadService,
    ) {
    }

    /**
     * @throws \Exception
     */
    #[Route('/new-challenge-set/{author}', name: 'app_new_challenge_set')]
    public function __invoke(Request $request, string $author): Response
    {
        $author = $this->authorRepository->findOneByEmailOrFail($author);
        $challengeSet = new Challenge();
        // $projects = $author->getProjects();
        // if (count($projects) === 0) {
        //     $project = new Project();
        // }
        // if (count($projects) === 1) {
        //     $project = $projects[0];
        // }

        $form = $this->createForm(ChallengeFormType::class, $challengeSet);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // if (null !== $photo = $form['photo']->getData()) {
            //     $imagePath = $this->uploadService->handle($photo, 'project');
            // }

            // if (null === $result = $this->projectRepository->findOneByTitleAndAreaOrFail($form['title']->getData(), $form['area']->getData())) {
            //     $project->addAuthor($author);
            //     $project->setArea($this->areaRepo->findOneBy(['id' => $form['area']->getData()]));
            //     $project->setStatus(1);
            //     $project->setAcceptedOn(new \DateTimeImmutable());
            //     if ($imagePath !== '') {
            //         $project->setImage($imagePath);
            //     }

            //     $this->entityManager->persist($project);
            //     $this->entityManager->flush();

            //     return $this->redirectToRoute('app_new_challenge', ['slug' => $project->getSlug()]);
            // }

            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('challenge-set/new-challenge.html.twig',
            [
                'breadcrumb' => 'Registre seu desafio',
                'project_form' => $form->createView(),
            ]
        );
    }
}
