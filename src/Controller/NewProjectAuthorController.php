<?php

namespace App\Controller;

use App\Entity\Author;
use App\Exception\AuthorAlreadyExistsException;
use App\Form\AuthorFormType;
use App\Repository\AuthorRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewProjectAuthorController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly AuthorRepositoryInterface $authorRepository,
    )
    {
    }

    #[Route('/new/authors/project', name: 'app_new_authors_project')]
    public function __invoke(Request $request): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorFormType::class, $author);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (null === $authorExistent = $this->authorRepository->findOneByEmailOrFail($author->getEmail())) {
                $author->markAsUpdated();

                $this->entityManager->persist($author);
                $this->entityManager->flush();

                return $this->redirectToRoute('app_new_project', ['author' => $author->getEmail()]);
            }

            return $this->redirectToRoute('app_new_project', ['author' => $author->getEmail()]);
        }

        return $this->render('new-project/new-project-author.html.twig', [
            'breadcrumb' => 'Incluir responsável pelo projeto',
            'author_form' => $form->createView(),
        ]);
    }
}
