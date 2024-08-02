<?php

namespace App\Repository;

use App\Entity\Eleve;
use Doctrine\ORM\EntityManagerInterface;

class EleveRepository extends \Doctrine\ORM\EntityRepository
{
// 	public function __construct(ManagerRegistry $registry) {
// 
// 		parent::__construct($registry, Eleve::class);
// 
// 	}



//    /**
//     * @return Eleve[] Returns an array of Deck objects
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

//    public function findOneBySomeField($value): ?Eleve
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
