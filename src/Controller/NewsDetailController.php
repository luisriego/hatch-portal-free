<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentFormType;
use App\Service\CommentRepeatedService;
use App\Service\SingleBlogService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsDetailController extends AbstractController
{
    public function __construct(
        // private readonly SingleBlogService $singleBlogService,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    #[Route('/news/{slug}', name: 'app_single_news')]
    public function __invoke(Request $request, $slug): Response
    {
        $blog = $this->singleBlogService->handle($slug);

        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (null !== $form['text']->getData()
                && $this->commentRepeatedService->handle(
                    $slug,
                    $form['email']->getData(),
                    $form['text']->getData())) {
                $comment->setBlog($blog);
                $comment->markAsUpdated();

                $this->entityManager->persist($comment);
                $this->entityManager->flush();
            }

            return $this->redirect($request->getUri());
        }

        return $this->render('blog/blog.base.html.twig',
            [
                'breadcrumb' => 'Blog',
                'blog' => $blog,
                'comment_form' => $form->createView(),
            ]);
    }
}
