<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\FavouriteCity;
use App\Service\FavouriteCitiesManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{

    /**
    * @Route("/admin", name="favourite_city_index")
    */
    public function index()
    {
        $cities = $this->getDoctrine()
            ->getRepository(FavouriteCity::class)
            ->findAll();

        return $this->render('admin/index.html.twig', ['cities' => $cities]);
    }

    /**
    * @Route("/admin/add", name="add_page")
    */
    public function addCity(Request $request, FavouriteCitiesManager $manager)
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('save', SubmitType::class, ['label' => 'Search for city'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $city = $form->getData();
            $data = $manager->getCityData($city['name']);

            return $this->render('admin/new.html.twig', [
                'form' => $form->createView(),
                'data' => $data,
            ]);
        }

        return $this->render('admin/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/admin/insert", name="insert_city")
    */
    public function insertCity(Request $request,  EntityManagerInterface $em)
    {

        //$request = Request::createFromGlobals();

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
        return $this->redirectToRoute('favourite_city_index');
    }

    /**
     * @Route("/admin/delete/{id}", name="favourite_city_delete", methods={"DELETE"})
     */
    public function delete(Request $request, FavouriteCity $favouriteCity): Response
    {
        if ($this->isCsrfTokenValid('delete'.$favouriteCity->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($favouriteCity);
            $entityManager->flush();
        }

        return $this->redirectToRoute('favourite_city_index');
    }
}