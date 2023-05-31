<?php

namespace App\Repository;

use App\Entity\Highlight;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class HighlightRepository extends ServiceEntityRepository implements HighlightRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Highlight::class);
    }

    public function save(Highlight $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Highlight $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllByProjectIdOrFail(string $id): ?array
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.project = :project')
            ->setParameter('project', $id)
            ->getQuery()
            ->getResult()
        ;
    }


//    public function findOneBySomeField($value): ?Highlight
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
