<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\HomepageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HomepageController extends AbstractController
{
    public function __construct(
        private readonly HomepageService $homepageService,
        private readonly Security $security,
        private readonly UserRepository $userRepo,
    ) {
    }


    #[Route('/', name: 'app_homepage')]
    public function __invoke(): Response
    {
        $randomData = $this->homepageService->handle();
        $user = $this->security->getUser();
        $noUser = null;
        if (!$user) {
            $users = $this->userRepo->findAll();
            $user = null;
            $noUser = $users[0]->getEmail();
        }

        return $this->render('homepage/index.html.twig',
            [
                'data' => $randomData,
                'user' => $user,
                'noUser' => $noUser,
            ]);
    }
}
