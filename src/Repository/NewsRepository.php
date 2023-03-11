<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<News>
 *
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }

    public function save(News $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(News $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return array|null
     */
    public function findRandomTreeOrFail(): ?array
    {
        return $this->createQueryBuilder('n')
            ->andWhere('t.toPublish = true')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }


    /**
     * @return int|null
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getTotalNumber(): ?int
    {
        return $this->createQueryBuilder('n')
            ->select('count(n.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
