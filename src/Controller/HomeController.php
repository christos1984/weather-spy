<?php

namespace App\Controller;

use App\Entity\FavouriteCity;
use App\Entity\WeatherData;
use DateInterval;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{

    /**
    * @Route("/", name="app_homepage")
    */
    public function index()
    {
        $favouriteCities = $this->getDoctrine()
            ->getRepository(FavouriteCity::class)
            ->findAll();

        if (!empty($favouriteCities)) {
            foreach ($favouriteCities as $favCity) {
                $temp[] = $this->getDoctrine()
                            ->getRepository(WeatherData::class)
                            ->findLatest($favCity->getId());
            }
        }
        else $temp = [];

        $lastUpdate = $this->getDoctrine()
                        ->getRepository(WeatherData::class)
                        ->findLastUpdateTime();

        if ($lastUpdate === null) {
            $lastUpdate = '';
        }

        else $lastUpdate = $lastUpdate->getTimeUpdated();

        $nextUpdate = new DateTime($lastUpdate->format(DateTime::ISO8601));
        $nextUpdate->modify('+10 minutes');


        return $this->render('home/index.html.twig', [
                'numbers' => $temp,
                'lastUpdate' => $lastUpdate ,
                'nextUpdate' => $nextUpdate ,
            ]);
    }
}