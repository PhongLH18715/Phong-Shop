<?php

namespace App\Controller;

use App\Entity\CarTypes;
use App\Form\CarTypeFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

class CarTypeController extends AbstractController
{
    /**
     * @Route("/manager/type/create", name="createCarType")
     */
    public function create(Request $request): Response
    {
        $carType = new CarTypes();
        //Tạo form dựa trên form type (xem App\Form\CarTypeFormType)
        $form = $this->createForm(CarTypeFormType::class, $carType); 
        $form->handleRequest($request);
        
        //Nếu submit form -> xử lý và quay lại trang quản lý
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            //Lưu (tạm thời)
            $manager->persist($carType);
            //Lưu vào database
            $manager->flush();
            //Thông báo (không quan trọng lắm)
            $this->addFlash("Info", "Create car type succeed!");
            //Điều hướng về trang quản lý (xem ManagerController)
            return $this->redirectToRoute("managerCarTypes"); 
        }

        //Nếu truy cập -> render trang create
        return $this->render('car_type/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/manager/type/delete/{id}", name="deleteCarType")
     */
    public function delete(Request $request, $id): Response
    {
        //Tìm theo id
        $carType = $this->getDoctrine()->getRepository(CarTypes::class)->find($id);
        
        //Nếu kết quả là null (không tìm thấy) thì điều hướng về trang quản lý
        if ($carType == null) {
            $this->addFlash("Error", "Delete failed!");
            return $this->redirectToRoute("managerCarTypes");   
        }
        $manager = $this->getDoctrine()->getManager();
        //Lấy danh sách xe có loại xe này và đặt về null

        $cars = $carType->getCars()->toArray();
        foreach ($cars as $c => $car) {
            $car->setCarType(null);
        }
        //Xóa 
        $manager->remove($carType);
        //Lưu thay đổi vào database
        $manager->flush();
        $this->addFlash("Info", "Delete car type succeed !");
        //Điều hướng về trang quản lý (xem ManagerController)
        return $this->redirectToRoute("managerCarTypes"); 
    }

    /**
     * @Route("/manager/type/update/{id}", name="updateCarType")
     */
    public function update(Request $request, $id): Response
    {
        //Tìm theo id
        $carType = $this->getDoctrine()->getRepository(CarTypes::class)->find($id);
        
        //Nếu kết quả là null (không tìm thấy) thì điều hướng về trang quản lý
        if ($carType == null) {
            $this->addFlash("Error", "Update failed!");
            return $this->redirectToRoute("managerCarTypes");   
        }

        $form = $this->createForm(CarTypeFormType::class, $carType); 
        $form->handleRequest($request);
        
        //Nếu submit form -> xử lý và quay lại trang quản lý
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            //Lưu (tạm thời)
            $manager->persist($carType);
            //Lưu vào database
            $manager->flush();
            //Thông báo (không quan trọng lắm)
            $this->addFlash("Info", "Update car type succeed!");
            //Điều hướng về trang quản lý (xem ManagerController)
            return $this->redirectToRoute("managerCarTypes"); 
        }

        //Nếu truy cập -> render trang update
        return $this->render('car_type/update.html.twig', [
            'form' => $form->createView()
        ]);
       
    }
}
