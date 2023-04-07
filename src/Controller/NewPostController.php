<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewPostController extends AbstractController
{
    #[Route('/new/post', name: 'app_new_post')]
    #[IsGranted("ROLE_USER")]
    public function index(): Response
    {

        $author = new Author();
        $form = $form = $this->createForm(AuthorFormType::class, $author);

        return $this->render('new-post/new-post.html.twig', [
            'breadcrumb' => 'Add new Post',
            'author_form' => $form->createView(),
        ]);
    }
}
