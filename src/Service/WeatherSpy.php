<?php

namespace App\Service;

use App\Entity\WeatherData;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\HttpClient;

class WeatherSpy
{

    public function fetchDataFromUpstream($city): ?Array
    {
            if (($city->getOwmId() == null)) return null;

            $apiKey = $_SERVER['API_KEY'];
            $googleApiUrl = "http://api.openweathermap.org/data/2.5/weather?id=" . $city->getOwmId() . "&lang=en&units=metric&APPID=" . $apiKey;

            $client = HttpClient::create();
            $response = $client->request('GET', $googleApiUrl);
            $content = $response->getContent();
            $content = $response->toArray();

            if ($response->getStatusCode() == '200'){
                $results =[
                    'id' => $city,
                    'main_weather' => $content['weather']['0']['main'],
                    'weather_description' => $content['weather']['0']['description'],
                    'temperature' => $content['main']['temp'],
                    'humidity' => $content['main']['humidity'],
                    'windspeed' => $content['wind']['speed'],
                    'icon' => $content['weather']['0']['icon'],
                ];

                return $results;
        }
        return null;
    }

    public function saveData(Array $results, EntityManagerInterface $em)
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
        $em->persist($wd);
        $em->flush();
    }
}