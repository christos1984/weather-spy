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

    public function getWeatherData($city, $from, $to)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.city = :city')
            ->andWhere('w.timeUpdated >= :from')
            ->andWhere('w.timeUpdated < :to')
            ->setParameter('city', $city)
            ->setParameter('from', $from)
            ->setParameter('to', $to)
            ->getQuery()
            ->getResult();
    }

    public function getDailyData($city, $date)
    {
        return $this->createQueryBuilder('w')
            ->select('w.temperature as temp, HOUR(w.timeUpdated) as time, DATE(w.timeUpdated) as date')
            ->andWhere('w.city = :city')
            ->andWhere('date = :from')
            ->setParameter('city', $city)
            ->setParameter('from', $date)
            ->groupBy('time')
            ->getQuery()
            ->getResult();
    }
}
