<?php

namespace App\Repository;

use App\Entity\EventTeacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EventTeacher>
 *
 * @method EventTeacher|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventTeacher|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventTeacher[]    findAll()
 * @method EventTeacher[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventTeacherRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventTeacher::class);
    }

//    /**
//     * @return EventTeacher[] Returns an array of EventTeacher objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EventTeacher
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
