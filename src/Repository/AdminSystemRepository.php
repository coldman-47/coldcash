<?php

namespace App\Repository;

use App\Entity\AdminSystem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AdminSystem|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminSystem|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdminSystem[]    findAll()
 * @method AdminSystem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminSystemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminSystem::class);
    }

    // /**
    //  * @return AdminSystem[] Returns an array of AdminSystem objects
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
    public function findOneBySomeField($value): ?AdminSystem
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
