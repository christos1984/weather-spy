<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\FavouriteCity;
use App\Service\Report;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class ReportController extends AbstractController
{

    /**
    * @Route("/report", name="report_homepage")
    */
    public function index(Request $request, Report $report)
    {

        $form = $this->createFormBuilder()
                ->add('city', EntityType::class, [
                        'class' => FavouriteCity::class,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('u')
                                ->orderBy('u.name', 'ASC');
                            },
                        'choice_label' => 'name',
                        'required'   => true,
                        'attr' => ['class' => 'form-control']
                ])
                ->add('fromDate', DateType::class,[
                        'widget' => 'single_text',
                        'html5' => false,
                        'required'   => true,
                        'attr' => ['class' => 'js-datepicker form-control'],
                ])

                ->add('toDate', DateType::class,[
                        'widget' => 'single_text',
                        'html5' => false,
                        'required'   => true,
                        'attr' => ['class' => 'js-datepicker form-control'],
                ])
                ->add('save', SubmitType::class, ['label' => 'Submit'])
                ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

            $res = $report->createReport($task);
                return $this->render('report/index.html.twig',[
                    'form' => $form->createView(),
                    'res' => $res,
                    'from' => $task['fromDate'],
                    'to' => $task['toDate'],
                    'city' => $task['city'],
                ]);
        }

        return $this->render('report/index.html.twig',[ 'form' => $form->createView()]);

    }
}