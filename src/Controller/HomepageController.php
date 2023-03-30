<?php

namespace App\Controller;

use App\Service\BlogService;
use App\Service\EventService;
use App\Service\HomepageService;
use App\Service\NewsService;
use App\Service\TestimonialService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    public function __construct(
        private readonly HomepageService $homepageService,
        private readonly NewsService $newsService,
        private readonly EventService $eventService,
        private readonly BlogService $blogService,
        private readonly TestimonialService $testimonialService,
    ) {
    }

    #[Route('/', name: 'app_homepage')]
    public function __invoke(): Response
    {
        $randomData = $this->homepageService->handle();
        $randomNews = $this->newsService->handle();
        $randomEvent = $this->eventService->handle();
        $randomBlog = $this->blogService->handle();
        $randomTestimonials = $this->testimonialService->handle();

        return $this->render('homepage/index.html.twig',
            [
                'data' => $randomData,
                'news' => $randomNews,
                'events' => $randomEvent,
                'blogs' => $randomBlog,
                'testimonial' => $randomTestimonials,
            ]);
    }
}
