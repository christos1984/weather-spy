<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\FavouriteCity;
use App\Entity\User;
use App\Service\Report;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class ReportController extends AbstractController
{

    /**
    * @Route("/report", name="report_homepage")
    */
    public function index(Request $request, Report $report)
    {

        $form = $this->createFormBuilder()
        ->add('users', EntityType::class, [
            'class' => FavouriteCity::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.name', 'ASC');
            },
            'choice_label' => 'name',
        ])
            ->add('fromDate', DateType::class,[
                'widget' => 'single_text',

                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => false,

                // adds a class that can be selected in JavaScript
                'attr' => ['class' => 'js-datepicker'],
            ])

            ->add('toDate', DateType::class,[
                'widget' => 'single_text',

                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => false,

                // adds a class that can be selected in JavaScript
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();



            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                // $form->getData() holds the submitted values
                // but, the original `$task` variable has also been updated
                $task = $form->getData();
                $res = $report->createReport($task);


                // ... perform some action, such as saving the task to the database
                // for example, if Task is a Doctrine entity, save it!
                // $entityManager = $this->getDoctrine()->getManager();
                // $entityManager->persist($task);
                // $entityManager->flush();

                return $this->render('report/index.html.twig',[ 'form' => $form->createView(),'res' => $res]);
            }

            return $this->render('report/index.html.twig',[ 'form' => $form->createView()]);

    }

     /**
    * @Route("/report/graph-daily", name="report_daily")
    */
    public function graphDay(Request $request, Report $report)
    {

        $form = $this->createFormBuilder()
        ->add('city', EntityType::class, [
            'class' => FavouriteCity::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.name', 'ASC');
            },
            'choice_label' => 'name',
        ])
            ->add('date', DateType::class,[
                'widget' => 'single_text',

                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => false,

                // adds a class that can be selected in JavaScript
                'attr' => ['class' => 'js-datepicker'],
            ])

            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                // $form->getData() holds the submitted values
                // but, the original `$task` variable has also been updated
                $task = $form->getData();
                $res = $report->createGraphDailyReport($task);
                dd($res);

                // ... perform some action, such as saving the task to the database
                // for example, if Task is a Doctrine entity, save it!
                // $entityManager = $this->getDoctrine()->getManager();
                // $entityManager->persist($task);
                // $entityManager->flush();

                return $this->render('report/index.html.twig',[ 'form' => $form->createView(),'res' => $res]);
            }

            return $this->render('report/index.html.twig',[ 'form' => $form->createView()]);

    }

}