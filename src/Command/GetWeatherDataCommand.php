<?php

namespace App\Command;

use App\Entity\FavouriteCity;
use App\Service\WeatherSpy;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetWeatherDataCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'weatherspy:fetch';

    private $em;
    private $spy;

    public function __construct(EntityManagerInterface $em, WeatherSpy $spy)
    {
        $this->em = $em;
        $this->spy = $spy;

        parent::__construct();
    }

    protected function configure()
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        echo "Fetching data...";
        echo "Press CTRL + C to interrupt\n";
        while (true) {
            $data = $this->em
                ->getRepository(FavouriteCity::class)
                ->findAll();
            foreach ($data as $city){
                $results = $this->spy->fetchDataFromUpstream($city);
                $this->spy->saveData($results, $this->em);
            }
            sleep(600);
        }
    }
}