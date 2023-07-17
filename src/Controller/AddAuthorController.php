<?php

namespace App\Controller;

use App\Entity\Author;
use App\Exception\AuthorAlreadyExistsException;
use App\Form\AuthorFormType;
use App\Repository\AuthorRepositoryInterface;
use App\Service\UploadFileService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddAuthorController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly AuthorRepositoryInterface $authorRepository,
        private readonly UploadFileService $uploadService,
    )
    {
    }

    #[Route('/add/author/{target}', name: 'app_add_author')]
    public function __invoke(Request $request, string $target = 'app_new_project'): Response
    {
        $avatarPath = '';
        $author = new Author();
        $form = $this->createForm(AuthorFormType::class, $author);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (null !== $avatar = $form['avatar']->getData()) {
                $avatarPath = $this->uploadService->handle($avatar, 'author');
            }

            if (null !== $authorExist = $this->authorRepository->findOneByEmailOrFail($author->getEmail())) {
                $authorExist->markAsUpdated();
                $authorExist->setResume($form['resume']->getData());
                $authorExist->setPosition($form['position']->getData());
                if ($avatarPath !== '') {
                    $authorExist->setAvatar($avatarPath);
                }

                $this->entityManager->persist($authorExist);
                $this->entityManager->flush();

                return $this->redirectToRoute($target, ['author' => $authorExist->getEmail()]);
            }

            $author->markAsUpdated();
            if ($avatarPath !== '') {
                $author->setAvatar($avatarPath);
            }

            $this->entityManager->persist($author);

            $this->entityManager->flush();
            return $this->redirectToRoute($target, ['author' => $author->getEmail()]);
        }

        if ($target === 'app_new_project') {
            return $this->render('new-project/new-project-author.html.twig', [
                'breadcrumb' => 'Incluir responsável do projeto',
                'author_form' => $form->createView(),
            ]);
        }

        if ($target === 'app_new_challenge_set') {
            return $this->render('new-project/new-project-author.html.twig', [
                'breadcrumb' => 'Incluir responsável do projeto',
                'author_form' => $form->createView(),
            ]);
        }

        // return $this->render('new-project/new-project-author.html.twig', [
        //     'breadcrumb' => 'Incluir responsável',
        //     'author_form' => $form->createView(),
        // ]);
    }
}
