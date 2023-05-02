<?php

namespace App\Repository;

use App\Entity\Blog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

class BlogRepository extends ServiceEntityRepository implements BlogRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Blog::class);
    }

    public function save(Blog $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Blog $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getTotalNumber(): ?int
    {
        return $this->createQueryBuilder('b')
            ->select('count(b.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function findOneByIdOrFail($id): ?Blog
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function findOneBySlugOrFail(string $slug): ?Blog
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getSingleResult();
    }

    public function findThreeActiveOrFail(int $limit = 3): ?array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.isActive = :val')
            ->setParameter('val', true)
            ->getQuery()
            ->getResult($limit);
    }


    public function getAllPostsActives(): ?array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.isActive = :val')
            ->setParameter('val', true)
            ->orderBy('b.date', 'ASC')
            ->setMaxResults(9)
            ->getQuery()
            ->getResult()
        ;
    }
}
