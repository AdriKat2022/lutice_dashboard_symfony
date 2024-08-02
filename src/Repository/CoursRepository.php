<?php

namespace App\Repository;

use App\Entity\Cours;
use Doctrine\ORM\EntityManagerInterface;

class CoursRepository extends \Doctrine\ORM\EntityRepository
{
// 	public function __construct(ManagerRegistry $registry) {
// 
// 		parent::__construct($registry, Cours::class);
// 
// 	}



//    /**
//     * @return Cours[] Returns an array of Deck objects
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

//    public function findOneBySomeField($value): ?Cours
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
