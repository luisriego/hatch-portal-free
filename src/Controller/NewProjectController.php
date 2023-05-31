<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectFormType;
use App\Repository\AreaRepository;
use App\Repository\AuthorRepository;
use App\Repository\AuthorRepositoryInterface;
use App\Repository\ProjectRepository;
use App\Repository\ProjectRepositoryInterface;
use App\Service\UploadFileService;
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
        private readonly ProjectRepositoryInterface $projectRepository,
        private readonly UploadFileService $uploadService,
    ) {
    }

    /**
     * @throws \Exception
     */
    #[Route('/new-project/{author}', name: 'app_new_project')]
    public function __invoke(Request $request, $author): Response
    {
        $imagePath = '';
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
            if (null !== $photo = $form['photo']->getData()) {
                $imagePath = $this->uploadService->handle($photo, 'project');
            }

            if (null === $result = $this->projectRepository->findOneByTitleAndAreaOrFail($form['title']->getData(), $form['area']->getData())) {
                $project->addAuthor($author);
                $project->setArea($this->areaRepo->findOneBy(['id' => $form['area']->getData()]));
                $project->setStatus(1);
                $project->setAcceptedOn(new \DateTimeImmutable());
                if ($imagePath !== '') {
                    $project->setImage($imagePath);
                }

                $this->entityManager->persist($project);
                $this->entityManager->flush();

                return $this->redirectToRoute('app_new_challenge', ['slug' => $project->getSlug()]);
            }

            return $this->redirectToRoute('app_new_challenge', ['slug' => $result->getSlug()]);
        }

        return $this->render('new-project/new-project.html.twig',
            [
                'breadcrumb' => 'Registre seu projeto',
                'project_form' => $form->createView(),
            ]);
    }
}
