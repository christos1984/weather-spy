<?php

namespace App\Controller;

use App\Entity\FavouriteCity;
use App\Entity\WeatherData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
        return $this->render('home/index.html.twig', [
                'numbers' => $temp,
                'lastUpdate' => $lastUpdate ,
            ]);
    }
}