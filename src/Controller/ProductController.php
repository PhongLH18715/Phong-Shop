<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\CarTypes;
use App\Entity\Manufacturer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ProductController extends AbstractController
{

    /**
     * @Route("/all", name="allCars")
     */
    public function viewAll(): Response
    {
        //Mặc định, xem tất cả sản phẩm (car)
        $carTypes = $this->getDoctrine()->getRepository(CarTypes::class)->findAll(); //Lấy danh sách thể loại xe, mục đích: hiển thị trên thanh điều hướng
        $manufacturers = $this->getDoctrine()->getRepository(Manufacturer::class)->findAll(); //Lấy danh sách các hãng sản xuất, mục đích: hiển thị trên thanh điều hướng
        $allCars = $this->getDoctrine()->getRepository(Car::class)->findAll(); //Lấy tất cả xe
        return $this->render('product/cars.html.twig', [
            'types' => $carTypes,
            'manufacturers' => $manufacturers,
            'cars' => $allCars
        ]);
    }

    /**
     * @Route("/manufacturer/{id}", name="filterByManufacturer")
     */
    public function filterByManufacturer($id): Response
    {
        //Xem các sản phẩm theo hãng sản xuất
        $carTypes = $this->getDoctrine()->getRepository(CarTypes::class)->findAll(); 
        $manufacturers = $this->getDoctrine()->getRepository(Manufacturer::class)->findAll(); 
        
        //Tìm hãng sản xuất theo id
        $manufacturer = $this->getDoctrine()->getRepository(Manufacturer::class)->find($id);
        //Nếu null tức là không tìm thấy, điều hướng về trang chủ (allCars)
        if ($manufacturer == null) return $this->redirectToRoute("allCars"); 
        //Lấy danh sách sản phẩm (xe) của hãng sản xuất
        $cars = $manufacturer->getCars();
        return $this->render('product/cars.html.twig', [
            'types' => $carTypes,
            'manufacturers' => $manufacturers,
            'cars' => $cars
        ]);
    }

    /**
     * @Route("/type/{id}", name="filterByType")
     */
    public function filterByType($id): Response
    {
        //Xem các sản phẩm theo loại xe

        $carTypes = $this->getDoctrine()->getRepository(CarTypes::class)->findAll(); 
        $manufacturers = $this->getDoctrine()->getRepository(Manufacturer::class)->findAll(); 
        
        //Tìm loại xe theo id
        $carType = $this->getDoctrine()->getRepository(CarTypes::class)->find($id);
        //Nếu null tức là không tìm thấy, điều hướng về trang chủ (allCars)
        if ($carType == null) return $this->redirectToRoute("allCars"); 
        //Lấy danh sách sản phẩm (xe) của hãng sản xuất
        $cars = $carType->getCars();
        return $this->render('product/cars.html.twig', [
            'types' => $carTypes,
            'manufacturers' => $manufacturers,
            'cars' => $cars
        ]);
    }

    
}
