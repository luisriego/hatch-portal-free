<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentFormType;
use App\Service\CommentRepeatedService;
use App\Service\SingleBlogService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    public function __construct(
        private readonly SingleBlogService $singleBlogService,
        private readonly CommentRepeatedService $commentRepeatedService,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    #[Route('/blog/{id}', name: 'app_single_blog')]
    public function __invoke(Request $request, $id): Response
    {
        $blog = $this->singleBlogService->handle($id);

        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (null !== $form['text']->getData()
                && $this->commentRepeatedService->handle(
                    $id,
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
