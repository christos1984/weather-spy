<?php

namespace App\Service;

use App\Entity\WeatherData;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\HttpClient;

class WeatherSpy
{
    public function __construct(EntityManagerInterface $em)
    {
        //$this->weatherData = $weatherData;
        /**
         * @Entity
         */
        $this->em = $em;
    }

    public function fetchDataFromUpstream(Array $cities): Array
    {

        foreach ($cities as $city)
        {
            $apiKey = $_SERVER['API_KEY'];
            $googleApiUrl = "http://api.openweathermap.org/data/2.5/weather?id=" . $city->getOwmId() . "&lang=en&units=metric&APPID=" . $apiKey;

            $client = HttpClient::create();
            $response = $client->request('GET', $googleApiUrl);

            $statusCode = $response->getStatusCode();
            // $statusCode = 200
            $content = $response->getContent();
            // $content = '{"id":521583, "name":"symfony-docs", ...}'
            $content = $response->toArray();



            $results =[
                'id' => $city,
                'main_weather' => $content['weather']['0']['main'],
                'weather_description' => $content['weather']['0']['description'],
                'temperature' => $content['main']['temp'],
                'humidity' => $content['main']['humidity'],
                'windspeed' => $content['wind']['speed'],
                'icon' => $content['weather']['0']['icon'],
            ];
            $this->saveData($results);
        }



        return [];
    }

    public function saveData(Array $results)
    {
        $wd = new WeatherData();
        $wd->setCity($results['id']);
        $wd->setMainWeather($results['main_weather']);
        $wd->setWeatherDescription($results['weather_description']);
        $wd->setTemperature($results['temperature']);
        $wd->setHumidity($results['humidity']);
        $wd->setTimeUpdated(new \DateTime());
        $wd->setWindspeed($results['windspeed']);
        $wd->setIcon($results['icon']);
        $this->em->persist($wd);
        $this->em->flush();
    }
}