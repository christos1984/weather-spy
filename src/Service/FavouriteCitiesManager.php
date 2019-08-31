<?php
// src/Service/MessageGenerator.php
namespace App\Service;

use App\Entity\AvailableCities;
use Doctrine\ORM\EntityManagerInterface;

class FavouriteCitiesManager
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function getCityData(String $city): Array
    {
        $data = $this->em->getRepository(AvailableCities::class)->findByExampleField($city);
        return $data;
    }
}