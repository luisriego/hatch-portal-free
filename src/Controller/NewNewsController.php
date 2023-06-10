<?php

namespace App\Controller;

use App\Entity\News;
use App\Form\NewsFormType;
use App\Service\UploadFileService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewNewsController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UploadFileService $uploadService,
    ) {
    }

    /**
     * @throws \Exception
     */
    #[Route('/news/new/', name: 'app_new_news')]
    public function __invoke(Request $request): Response
    {
        $photoPath = '';
        $news = new News();
        $form = $this->createForm(NewsFormType::class, $news);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($photo = $form['photo']->getData()) {
                $photoPath = $this->uploadService->handle($photo, 'news');
            }

            $news->setDate($form['publishedOn']->getData()->format('d/m/Y'));
            if ('' !== $photoPath) {
                $news->setImage($photoPath);
            }

            $this->entityManager->persist($news);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('new-news/new-news.html.twig', [
            'breadcrumb' => 'Nova notícia',
            'news_form' => $form->createView(),
        ]);
    }
}
