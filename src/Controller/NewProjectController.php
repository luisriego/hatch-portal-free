<?php

namespace App\Controller;

use App\Entity\Project;
use App\Exception\UnableToLoadPhotoException;
use App\Form\ProjectFormType;
use App\Repository\AreaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewProjectController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly AreaRepository $areaRepo)
    {
    }

    #[Route('/new-project', name: 'app_new_project')]
    public function __invoke(Request $request, string $photoDir): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectFormType::class, $project);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $filesystem = new Filesystem();

            if ($photo = $form['photo']->getData()) {
                $filename = bin2hex(random_bytes(6)).'.'.$photo->guessExtension();

                try {
                    $photo->move($photoDir, $filename);
//                    $filesystem->touch(
//                        Path::normalize($photoDir.'/'.$filename)
//                    );
                } catch (IOExceptionInterface  $e) {
                    echo "An error occurred while creating your directory at ".$e->getPath();
                }
            }

            $areaId = $form['area']->getData();
            $area = $this->areaRepo->findOneBy(['id' => $areaId]);

            $project->setArea($area);
            $project->setImage($filename);
            $this->entityManager->persist($project);
            $this->entityManager->flush();

            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('new-project/new-project.html.twig',
            [
                'project_form' => $form->createView(),
            ]);
    }
}
