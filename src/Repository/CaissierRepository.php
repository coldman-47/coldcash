<?php

namespace App\Repository;

use App\Entity\Caissier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Caissier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Caissier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Caissier[]    findAll()
 * @method Caissier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaissierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Caissier::class);
    }

    // /**
    //  * @return Caissier[] Returns an array of Caissier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Caissier
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
