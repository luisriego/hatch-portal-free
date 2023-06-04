<?php

namespace App\Repository;

use App\Entity\ChallengeLaunched;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

class ChallengeLaunchedRepository extends ServiceEntityRepository implements ChallengeLaunchedRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChallengeLaunched::class);
    }

    public function save(ChallengeLaunched $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ChallengeLaunched $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function findOneBySlugOrFail(string $slug): ?ChallengeLaunched
    {
        return $this->createQueryBuilder('cl')
            ->andWhere('cl.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getTotalNumber(): ?int
    {
        return $this->createQueryBuilder('cl')
            ->select('count(cl.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getAllChallengesLaunchedActives(): ?array
    {
        return $this->createQueryBuilder('cl')
            ->andWhere('cl.isActive = :val')
            ->setParameter('val', true)
            ->orderBy('cl.createdOn', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
