<?php

namespace App\Repository;

use App\Entity\FavouriteCity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FavouriteCity|null find($id, $lockMode = null, $lockVersion = null)
 * @method FavouriteCity|null findOneBy(array $criteria, array $orderBy = null)
 * @method FavouriteCity[]    findAll()
 * @method FavouriteCity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavouriteCityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FavouriteCity::class);
    }

    // /**
    //  * @return FavouriteCity[] Returns an array of FavouriteCity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FavouriteCity
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
