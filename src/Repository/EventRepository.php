<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class EventRepository
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

//    public function save(Event $entity, bool $flush = false): void
//    {
//        $this->getEntityManager()->persist($entity);
//
//        if ($flush) {
//            $this->getEntityManager()->flush();
//        }
//    }
//
//    public function remove(Event $entity, bool $flush = false): void
//    {
//        $this->getEntityManager()->remove($entity);
//
//        if ($flush) {
//            $this->getEntityManager()->flush();
//        }
//    }

    public function findRandom3withSQL(): ?array
    {
        $rsm = new ResultSetMappingBuilder($this->em);
        $rsm->addRootEntityFromClassMetadata(Event::class, 'e');

        $query = $this->em->createNativeQuery('SELECT * FROM event e LIMIT 3', $rsm);

        return $query->getResult();
    }
}
