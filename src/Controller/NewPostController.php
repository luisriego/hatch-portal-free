<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\BlogFormType;
use App\Repository\AuthorRepository;
use App\Service\UploadFileService;
use Cloudinary\Cloudinary;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewPostController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly AuthorRepository $authorRepository,
        private readonly UploadFileService $uploadService,
    ) {
    }

    /**
     * @throws \Exception
     */
    #[Route('/new/post/{authorId}', name: 'app_new_post')]
    public function __invoke(Request $request, $authorId): Response
    {
        // Configure an instance of your Cloudinary cloud

        $photoPath = '';
        $author = $this->authorRepository->findOneBy(['id' => $authorId]);
        $blog = new Blog();
        $form = $this->createForm(BlogFormType::class, $blog);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($photo = $form['photo']->getData()) {
                $photoPath = $this->uploadService->handle($photo, 'blog');
            }

            $blog->setOwner($author);
            $blog->setAuthor($author->getName().' '.$author->getSurname());
            if ('' !== $photoPath) {
                $blog->setPhoto($photoPath);
            }

            $this->entityManager->persist($blog);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('new-post/new-post.html.twig', [
            'breadcrumb' => 'Novo Post',
            'post_form' => $form->createView(),
        ]);
    }
}
