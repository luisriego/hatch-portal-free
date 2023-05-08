<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\BlogFormType;
use App\Repository\AuthorRepository;
use Cloudinary\Api\Exception\ApiError;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewPostController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly AuthorRepository $authorRepository,
    ) {
    }

    /**
     * @throws \Exception
     */
    #[Route('/new/post/{authorId}', name: 'app_new_post')]
    public function __invoke(Request $request, $authorId, string $cloudinaryKey, string $cloudinarySecret): Response
    {
        // Configure an instance of your Cloudinary cloud

        $author = $this->authorRepository->findOneBy(['id' => $authorId]);
        $blog = new Blog();
        $form = $this->createForm(BlogFormType::class, $blog);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($photo = $form['photo']->getData()) {
                $filename = bin2hex(random_bytes(6));

                try {
                    $cloudinary = new Cloudinary(
                        [
                            'cloud' => [
                                'cloud_name' => 'inovacaobrasil',
                                'api_key'    => $cloudinaryKey,
                                'api_secret' => $cloudinarySecret,
                            ],
                        ]
                    );

                    $cloudinary->uploadApi()->upload(
                        $photo->getRealPath(),
                        ['public_id' => $filename, 'folder' => 'blog']
                    );
                    $blog->setPhoto('https://res.cloudinary.com/inovacaobrasil/image/upload/v1683423312/blog/'.$filename);
                } catch (ApiError $e) {
                    echo 'An error occurred while creating your directory at '.$e;
                }
            }

            $blog->setOwner($author);
            $blog->setAuthor($author->getName().' '.$author->getSurname());

            $this->entityManager->persist($blog);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('new-post/new-post.html.twig', [
            'breadcrumb' => 'Novo Post',
            'post_form' => $form->createView(),
        ]);
    }
}
