<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;

class EventRepository extends \Doctrine\ORM\EntityRepository
{
// 	public function __construct(ManagerRegistry $registry) {
// 
// 		parent::__construct($registry, Event::class);
// 
// 	}



//    /**
//     * @return Event[] Returns an array of Deck objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Event
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
