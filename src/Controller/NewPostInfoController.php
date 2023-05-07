<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewPostInfoController extends AbstractController
{
    #[Route('/new/info/post', name: 'app_new_info_post')]
    public function index(): Response
    {
        return $this->render('new-post/new-info.html.twig', [
            'breadcrumb' => 'Info about add new Post',
        ]);
    }
}
