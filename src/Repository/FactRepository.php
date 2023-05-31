<?php

namespace App\Repository;

use App\Entity\Fact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class FactRepository extends ServiceEntityRepository implements FactRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fact::class);
    }

    public function save(Fact $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Fact $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllByProjectIdOrFail(string $id): ?array
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.project = :project')
            ->setParameter('project', $id)
            ->getQuery()
            ->getResult()
            ;
    }

//    public function findOneBySomeField($value): ?Fact
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
