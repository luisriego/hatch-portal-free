<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Blog;
use App\Repository\BlogRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SingleBlogService
{
    public function __construct(private readonly BlogRepository $blogRepository)
    {
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    public function handle(string $id): Blog|null
    {
        if (null === $result = $this->blogRepository->findOneByIdOrFail($id)) {
            throw new NotFoundHttpException();
        }

        return $result;
    }
}
