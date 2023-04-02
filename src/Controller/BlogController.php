<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\AboutUsService;
use App\Service\SingleBlogService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    public function __construct(
        private readonly SingleBlogService $singleBlogService
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

        return $this->render('blog/blog.base.html.twig',
            [
                'breadcrumb' => 'Blog',
                'blog' => $blog
            ]);
    }
}
