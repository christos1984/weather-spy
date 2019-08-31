<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\FavouriteCity;
use App\Entity\AvailableCities;
use App\Service\FavouriteCitiesManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{

    /**
    * @Route("/admin2", name="admin_homepage")
    */
    public function index()
    {
        $cities = $this->getDoctrine()
            ->getRepository(FavouriteCity::class)
            ->findAll();

        return $this->render('admin/index.html.twig', ['cities' => $cities]);
    }

    /**
    * @Route("/admin2/add", name="add_page")
    */
    public function addCity(Request $request, FavouriteCitiesManager $manager)
    {
        // creates a task object and initializes some data for this example
        $task = new FavouriteCity();


        $form = $this->createFormBuilder()
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $data = $manager->getCityData($task['name']);

            return $this->render('task/new.html.twig', [
                'form' => $form->createView(),
                'data' => $data,
            ]);
        }

        return $this->render('task/new.html.twig', [
            'form' => $form->createView(),
        ]);

    }


    /**
    * @Route("/admin2/insert", name="insert_city")
    */
    public function insertCity(Request $request,  EntityManagerInterface $em)
    {
        $request = Request::createFromGlobals();

        $owmid = $request->request->get("id");
        $name = $request->request->get("name");
        $country = $request->request->get("country");
        $city = new FavouriteCity();
        $ent = $em->getRepository(FavouriteCity::class)->findOneBy(['name' => $name]);

        if ($ent == null) {
            $city->setCountryCode($country);
            $city->setName($name);
            $city->setOwmId($owmid);

            $em->persist($city);
            $em->flush();
        }

    }
}