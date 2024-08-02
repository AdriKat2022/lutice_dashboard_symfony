<?php

namespace App\Repository;

use App\Entity\Meeting;
use Doctrine\ORM\EntityManagerInterface;

class MeetingRepository extends \Doctrine\ORM\EntityRepository
{
// 	public function __construct(ManagerRegistry $registry) {
// 
// 		parent::__construct($registry, Meeting::class);
// 
// 	}



//    /**
//     * @return Meeting[] Returns an array of Deck objects
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

//    public function findOneBySomeField($value): ?Meeting
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
