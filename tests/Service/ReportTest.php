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
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class ReportTest extends TestCase
{
    public function testCreateReportForCorrectData()
    {

        $availableCity = new AvailableCities();
        $availableCity->setId('45324');

        $data = ['city'=>$availableCity,'fromDate'=>new DateTime('2019-03-03 00:00:00'), 'toDate'=>new DateTime('2019-03-03 00:00:00')];

        $favouriteCity = new FavouriteCity();
        $favouriteCity->setCountryCode('GR');
        $favouriteCity->setName('Athens');
        $favouriteCity->setOwmId(45324);

        $wd = new WeatherData();
        $wd->setCity($favouriteCity);
        $wd->setHumidity(43.3);
        $wd->setIcon('1d');
        $wd->setMainWeather('Windy');
        $wd->setTemperature(32.2);
        $wd->setTimeUpdated(new DateTime('now'));
        $wd->setWeatherDescription('Gusts');

        // Now, mock the repository so it returns the mock of the employee
        $wdRepo = $this->createMock(WeatherDataRepository::class);
        // use getMock() on PHPUnit 5.3 or below
        // $employeeRepository = $this->getMock(ObjectRepository::class);
        $wdRepo->expects($this->any())
            ->method('getWeatherData')

            ->willReturn([$wd]);

        // Last, mock the EntityManager to return the mock of the repository
        $objectManager = $this->createMock(EntityManagerInterface::class);
        // use getMock() on PHPUnit 5.3 or below
        // $objectManager = $this->getMock(ObjectManager::class);
        $objectManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($wdRepo);

        $report = new Report($objectManager);
        $a = $report->createReport($data);

        $this->assertIsArray($a);
    }

    public function testCreateReportForIncorrectData()
    {

        $availableCity = new AvailableCities();
        $availableCity->setId('45324');

        $data = ['city'=>$availableCity,'fromDate'=>new DateTime('2019-03-03 00:00:00'), 'toDate'=>new DateTime('2019-03-03 00:00:00')];



        // Now, mock the repository so it returns the mock of the employee
        $wdRepo = $this->createMock(WeatherDataRepository::class);
        // use getMock() on PHPUnit 5.3 or below
        // $employeeRepository = $this->getMock(ObjectRepository::class);
        $wdRepo->expects($this->any())
            ->method('getWeatherData')

            ->willReturn([null]);

        // Last, mock the EntityManager to return the mock of the repository
        $objectManager = $this->createMock(EntityManagerInterface::class);
        // use getMock() on PHPUnit 5.3 or below
        // $objectManager = $this->getMock(ObjectManager::class);
        $objectManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($wdRepo);

        $report = new Report($objectManager);
        $a = $report->createReport($data);

        $this->assertNull($a[0]);
    }
}