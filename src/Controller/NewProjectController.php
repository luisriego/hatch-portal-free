<?php

namespace App\Controller;

use App\Entity\Project;
use App\Exception\UnableToLoadPhotoException;
use App\Form\ProjectFormType;
use App\Repository\AreaRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class NewProjectController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly AreaRepository $areaRepo,
        private readonly ProjectRepository $projectRepository)
    {
    }

    #[Route('/new-project', name: 'app_new_project')]
    public function __invoke(Request $request, string $photoDir): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectFormType::class, $project);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($photo = $form['photo']->getData()) {
                $filename = bin2hex(random_bytes(6)).'.'.$photo->guessExtension();

                try {
                    $photo->move($photoDir, $filename);
                    $project->setImage($filename);
                } catch (IOExceptionInterface  $e) {
                    echo "An error occurred while creating your directory at ".$e->getPath();
                }
            }

            if (null === $result = $this->projectRepository->findOneBy(['title' => $form['title']->getData(), 'area' => $form['area']->getData()])) {
                $project->setArea($this->areaRepo->findOneBy(['id' => $form['area']->getData()]));
                $project->setStatus(1);

                $this->entityManager->persist($project);
                $this->entityManager->flush();

                return $this->redirectToRoute('app_new_challenge', ['projectId' => $project->getId()]);
            }

            return $this->redirectToRoute('app_new_challenge', ['projectId' => $result->getId()]);
        }

        return $this->render('new-project/new-project.html.twig',
            [
                'breadcrumb' => 'Add project',
                'project_form' => $form->createView(),
            ]);
    }
}
