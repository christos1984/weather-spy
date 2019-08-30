<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\FavouriteCity;
use App\Entity\AvailableCities;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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
    public function addCity()
    {
        // creates a task object and initializes some data for this example
        $task = new FavouriteCity();


        $form = $this->createFormBuilder($task)
            ->add('name', TextType::class)
            ->add('owmid',  EntityType::class, [
                'class' => AvailableCities::class,
                'choice_label' => 'id',])
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();

            return $this->render('task/new.html.twig', [
                'form' => $form->createView(),
            ]);
    }
}