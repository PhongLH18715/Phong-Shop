<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\CarTypes;
use App\Entity\Manufacturer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ManagerController extends AbstractController
{
    /**
     * @Route("/manager/car", name="managerCars")
     */
    public function managerCars(): Response
    {
        $cars = $this->getDoctrine()->getRepository(Car::class)->findAll(); //Lấy danh sách xe
        return $this->render('manager/car.html.twig', [
            'cars' => $cars
        ]);
    }

    /**
     * @Route("/manager/manufacturer", name="managerManufacturers")
     */
    public function managerManufacturers(): Response
    {
        $manufacturers = $this->getDoctrine()->getRepository(Manufacturer::class)->findAll(); //Lấy danh sách hãng xe
        return $this->render('manager/manufacturer.html.twig', [
            'manufacturers' => $manufacturers
        ]);
    }

    /**
     * @Route("/manager/type", name="managerCarTypes")
     */
    public function managerCarTypes(): Response
    {
        $carTypes = $this->getDoctrine()->getRepository(CarTypes::class)->findAll(); //Lấy danh sách loại xe
        return $this->render('manager/type.html.twig', [
            'types' => $carTypes
        ]);
    }
}
