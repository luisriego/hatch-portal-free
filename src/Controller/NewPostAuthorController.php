<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorFormType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewPostAuthorController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager,)
    {
    }

    #[Route('/new/author/post', name: 'app_new_author_post')]
    public function __invoke(Request $request): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorFormType::class, $author);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $author->markAsUpdated();

            $this->entityManager->persist($author);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_new_post', ['authorId' => $author->getId()]);
        }

        return $this->render('new-post/new-post-author.html.twig', [
            'breadcrumb' => 'Add new Post',
            'author_form' => $form->createView(),
        ]);
    }
}
