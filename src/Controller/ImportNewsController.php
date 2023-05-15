<?php

namespace App\Controller;

use App\Entity\News;
use App\Form\ImportNewsFormType;
use App\Service\ScrapNewsService;
use App\Service\UploadFileService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImportNewsController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UploadFileService $uploadService,
        private readonly ScrapNewsService $scrapNewsService,
    ) {
    }

    /**
     * @throws \Exception
     */
    #[Route('/news/import/', name: 'app_import_news')]
    public function __invoke(Request $request): Response
    {
        $photoPath = '';
        $news = new News();
        $form = $this->createForm(ImportNewsFormType::class, $news);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $news = $this->scrapNewsService->handle($form['url']->getData());
//            if ($photo = $form['photo']->getData()) {
//                $photoPath = $this->uploadService->handle($photo, 'news');
//            }
//
//            $news->setDate($form['publishedOn']->getData()->format('d/m/Y'));
//            if ($photoPath !== '') {
//                $news->setImage($photoPath);
//            }
//
//            $this->entityManager->persist($news);
//            $this->entityManager->flush();
//
//            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('new-news/import-news.html.twig', [
            'breadcrumb' => 'Importar notícia',
            'import_news_form' => $form->createView(),
        ]);
    }
}
