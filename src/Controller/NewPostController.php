<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Blog;
use App\Form\AuthorFormType;
use App\Form\BlogFormType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewPostController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly AuthorRepository $authorRepository,
    ) {
    }

    #[Route('/new/post/{authorId}', name: 'app_new_post')]
    public function __invoke(Request $request, $authorId, string $blogDir): Response
    {
        $author = $this->authorRepository->findOneBy(['id' => $authorId]);
        $blog = new Blog();
        $form = $this->createForm(BlogFormType::class, $blog);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($photo = $form['photo']->getData()) {
                $filename = bin2hex(random_bytes(6)).'.'.$photo->guessExtension();

                try {
                    $photo->move($blogDir, $filename);
                    $blog->setPhoto($filename);
                } catch (IOExceptionInterface  $e) {
                    echo 'An error occurred while creating your directory at '.$e->getPath();
                }
            }

            $blog->setOwner($author);
            $blog->setAuthor($author->getName() . ' ' . $author->getSurname());

            $this->entityManager->persist($blog);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('new-post/new-post.html.twig', [
            'breadcrumb' => 'Add new Post',
            'post_form' => $form->createView(),
        ]);
    }
}
