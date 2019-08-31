<?php

namespace App\Service;

use App\Entity\WeatherData;
use Doctrine\ORM\EntityManagerInterface;

class Report
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function createReport (Array $input): Array
    {
        $fromDate = $input['fromDate'];
        $toDate = $input['toDate'];
        $city = $input['city'];

        $res = $this->em->getRepository(WeatherData::class)
                ->getWeatherData($city->getId(),$fromDate->format('Y-m-d H:i:s'),$toDate->format('Y-m-d 23:59:59'));
        return $res;
    }

    public function createGraphDailyReport(Array $input): Array
    {
        $date = $input['date'];
        $city = $input['city'];

        $res = $this->em->getRepository(WeatherData::class)
                 ->getDailyData($city->getId(),$date->format('Y-m-d'));

        return $res;
    }
}