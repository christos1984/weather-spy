<?php

// src/Command/CreateUserCommand.php
namespace App\Command;

use App\Entity\FavouriteCity;
use App\Service\FavouriteCitiesManager;
use App\Service\WeatherSpy;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetWeatherDataCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:create-user';

    private $favManager;

    public function __construct(FavouriteCitiesManager $favManager, EntityManagerInterface $em, WeatherSpy $spy)
    {
        $this->favManager = $favManager;
        $this->em = $em;
        $this->spy = $spy;

        parent::__construct();
    }

    protected function configure()
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //echo $this->favManager->getHappyMessage();die;





        echo "long process";
        while (true) {


            $product = $this->em
            ->getRepository(FavouriteCity::class)
            ->findAll();
            //var_dump($product);die;
            $this->spy->fetchDataFromUpstream($product);
            sleep(600);
        }
    }
}