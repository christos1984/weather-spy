<?php

namespace App\Tests\Service;

use App\Entity\AvailableCities;
use App\Entity\WeatherData;
use DatePeriod;
use DateTime;
use PHPUnit\Framework\TestCase;
use App\Entity\FavouriteCity;
use App\Repository\WeatherDataRepository;
use App\Service\Report;
use App\Service\WeatherSpy;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\Exception\ClientException;

class WeatherSpyTest extends TestCase
{
    public function testFetchForCorrectCitiesShouldReturnArray()
    {
        $favouriteCity = new FavouriteCity();
        $favouriteCity->setCountryCode('GR');
        $favouriteCity->setName('Ymittos Athens');
        $favouriteCity->setOwmId(8131587);

        $ws = new WeatherSpy();
        $res = $ws->fetchDataFromUpstream($favouriteCity);
        $this->assertArrayHasKey('main_weather', $res);
    }


    /**
    * @expectedException Symfony\Component\HttpClient\Exception\ClientException
    */
    public function testFetchForIncorrectCitiesShouldReturnException()
    {
        $favouriteCity = new FavouriteCity();
        $favouriteCity->setCountryCode('GR');
        $favouriteCity->setName('Ymittos Athens');
        $favouriteCity->setOwmId(8131587234213423);



        $ws = new WeatherSpy();
        $res = $ws->fetchDataFromUpstream($favouriteCity);
    }

    public function testFetchForEmptyCitiesShouldReturnEmpty()
    {

        $cities = new FavouriteCity();

        $ws = new WeatherSpy();
        $res = $ws->fetchDataFromUpstream($cities);

        $this->assertNull($res);
    }
}