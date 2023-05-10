<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorFormType;
use App\Repository\AuthorRepositoryInterface;
use App\Service\UploadFileService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewNewsAuthorController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly AuthorRepositoryInterface $authorRepository,
        private readonly UploadFileService $uploadService,
    ) {
    }

    #[Route('/news/author/new', name: 'app_news_author')]
    public function __invoke(Request $request): Response
    {
        $avatarPath = '';
        $author = new Author();
        $form = $this->createForm(AuthorFormType::class, $author);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (null !== $avatar = $form['avatar']->getData()) {
                $avatarPath = $this->uploadService->handle($avatar, 'author');
            }

            if (null !== $authorExist = $this->authorRepository->findOneByEmailOrFail($form['email']->getData())) {
                $authorExist->markAsUpdated();
                $authorExist->setResume($form['resume']->getData());
                $authorExist->setPosition($form['position']->getData());
                if ($avatarPath !== '') {
                    $authorExist->setAvatar($avatarPath);
                }

                $this->entityManager->persist($authorExist);
                $this->entityManager->flush();

                return $this->redirectToRoute('app_new_news', ['authorId' => $authorExist->getId()]);
            }
            $author->markAsUpdated();
            if ($avatarPath !== '') {
                $author->setAvatar($avatarPath);
            }

            $this->entityManager->persist($author);

            $this->entityManager->flush();

            return $this->redirectToRoute('app_new_news', ['authorId' => $author->getId()]);
        }

        return $this->render('new-news/new-news-author.html.twig', [
            'breadcrumb' => 'Incluir nova notícia',
            'author_form' => $form->createView(),
        ]);
    }
}
