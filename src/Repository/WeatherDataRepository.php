<?php

namespace App\Repository;

use App\Entity\WeatherData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method WeatherData|null find($id, $lockMode = null, $lockVersion = null)
 * @method WeatherData|null findOneBy(array $criteria, array $orderBy = null)
 * @method WeatherData[]    findAll()
 * @method WeatherData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeatherDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WeatherData::class);
    }

    // /**
    //  * @return WeatherData[] Returns an array of WeatherData objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WeatherData
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findLatest($city): ?WeatherData
    {
        return $this->createQueryBuilder('w')
        ->andWhere('w.city= :val')
        ->setParameter('val', $city)
        ->orderBy('w.timeUpdated', 'DESC')
        ->setMaxResults('1')
        ->getQuery()
        ->getOneOrNullResult();
    }

    public function findLastUpdateTime()
    {
        return $this->createQueryBuilder('w')
            ->orderBy('w.timeUpdated', 'DESC')
            ->setMaxResults('1')
            ->getQuery()
            ->getOneOrNullResult();
    }
}
