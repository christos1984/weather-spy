<?php

namespace App\Repository;

use App\Entity\AvailableCities;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AvailableCities|null find($id, $lockMode = null, $lockVersion = null)
 * @method AvailableCities|null findOneBy(array $criteria, array $orderBy = null)
 * @method AvailableCities[]    findAll()
 * @method AvailableCities[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvailableCitiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AvailableCities::class);
    }

    /**
    * @return AvailableCities[] Returns an array of AvailableCities objects
    */
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.name = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value):
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
