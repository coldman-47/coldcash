<?php

namespace App\Repository;

use App\Entity\AdminAgence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AdminAgence|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminAgence|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdminAgence[]    findAll()
 * @method AdminAgence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminAgenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminAgence::class);
    }

    // /**
    //  * @return AdminAgence[] Returns an array of AdminAgence objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AdminAgence
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
