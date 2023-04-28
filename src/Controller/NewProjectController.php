<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectFormType;
use App\Repository\AreaRepository;
use App\Repository\AuthorRepository;
use App\Repository\AuthorRepositoryInterface;
use App\Repository\ProjectRepository;
use App\Repository\ProjectRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewProjectController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly AreaRepository $areaRepo,
        private readonly AuthorRepositoryInterface $authorRepository,
        private readonly ProjectRepositoryInterface $projectRepository)
    {
    }

    #[Route('/new-project/{author}', name: 'app_new_project')]
    public function __invoke(Request $request, $author, string $photoDir): Response
    {
        $author = $this->authorRepository->findOneByEmailOrFail($author);
        $projects = $author->getProjects();
        if (count($projects) === 0) {
            $project = new Project();
        }
        if (count($projects) === 1) {
            $project = $projects[0];
        }

        $form = $this->createForm(ProjectFormType::class, $project);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($photo = $form['photo']->getData()) {
                $filename = bin2hex(random_bytes(6)).'.'.$photo->guessExtension();

                try {
                    $photo->move($photoDir, $filename);
                    $project->setImage($filename);
                } catch (IOExceptionInterface  $e) {
                    echo 'An error occurred while creating your directory at '.$e->getPath();
                }
            }

            if (null === $result = $this->projectRepository->findOneBy(['title' => $form['title']->getData(), 'area' => $form['area']->getData()])) {
                $project->addAuthor($author);
                $project->setArea($this->areaRepo->findOneBy(['id' => $form['area']->getData()]));
                $project->setStatus(1);

                $this->entityManager->persist($project);
                $this->entityManager->flush();

                return $this->redirectToRoute('app_new_challenge', ['slug' => $project->getSlug()]);
            }

            return $this->redirectToRoute('app_new_challenge', ['slug' => $result->getSlug()]);
        }

        return $this->render('new-project/new-project.html.twig',
            [
                'breadcrumb' => 'Add project',
                'project_form' => $form->createView(),
            ]);
    }
}
