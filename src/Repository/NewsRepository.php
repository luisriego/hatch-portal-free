<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\Persistence\ManagerRegistry;


class NewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }

//    public function save(News $entity, bool $flush = false): void
//    {
//        $this->getEntityManager()->persist($entity);
//
//        if ($flush) {
//            $this->getEntityManager()->flush();
//        }
//    }
//
//    public function remove(News $entity, bool $flush = false): void
//    {
//        $this->getEntityManager()->remove($entity);
//
//        if ($flush) {
//            $this->getEntityManager()->flush();
//        }
//    }
//
    /**
     * @return array|null
     */
    public function findRandomTreeOrFail(): ?array
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.toPublish = true')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }
//
//
//    public function getTotalNumber(): ?int
//    {
//        return $this->createQueryBuilder('n')
//            ->select('count(n.id)')
//            ->getQuery()
//            ->getSingleScalarResult();
//    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    public function getTotalNumber(): ?int
    {
        return $this->createQueryBuilder('n')
            ->select('count(n.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getTotalNumberWithSQL(): ?array
    {
        $rsm = new ResultSetMappingBuilder($this->em);
        $rsm->addRootEntityFromClassMetadata(News::class, 'n');

        $query = $this->em->createNativeQuery('SELECT COUNT(n.id) FROM news', $rsm);

        return $query->getResult();
    }

    public function findRandom3withSQL(): ?array
    {
        $rsm = new ResultSetMappingBuilder($this->em);
        $rsm->addRootEntityFromClassMetadata(News::class, 'n');

        $query = $this->em->createNativeQuery('SELECT * FROM news n WHERE n.to_publish = true LIMIT 3', $rsm);

        return $query->getResult();
    }
}
