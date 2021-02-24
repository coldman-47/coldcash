<?php

namespace App\Repository;

use App\Entity\TransactionEnCours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TransactionEnCours|null find($id, $lockMode = null, $lockVersion = null)
 * @method TransactionEnCours|null findOneBy(array $criteria, array $orderBy = null)
 * @method TransactionEnCours[]    findAll()
 * @method TransactionEnCours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionEnCoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TransactionEnCours::class);
    }

    // /**
    //  * @return TransactionEnCours[] Returns an array of TransactionEnCours objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TransactionEnCours
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
