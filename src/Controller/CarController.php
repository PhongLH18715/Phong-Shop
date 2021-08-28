<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\CarTypes;
use App\Entity\Manufacturer;
use App\Form\CarFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class CarController extends AbstractController
{
    /**
     * @Route("/manager/car/create", name="createCar")
     */
    public function create(Request $request): Response
    {
        $car = new Car();
        $form = $this->createForm(CarFormType::class, $car); 
        $form->handleRequest($request);
        
        //summit to back manager
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $image = $form->get('ImageFile')->getData();
            if ($image != null) {
                $fileName = md5(uniqid());
                $fileExtension = $image->guessExtension();
                $imageName = $fileName . '.' . $fileExtension;
                try {
                    $image->move(
                        $this->getParameter('images_directory'), $imageName
                    );
                } catch (FileException $e) {
                    return new Response(
                        json_encode(['error' => $e->getMessage()]),
                        Response::HTTP_INTERNAL_SERVER_ERROR,
                        [
                            'content-type' => 'application/json'
                        ]
                    );
                }

                $car->setImage($imageName);
            }

            $manager->persist($car);
 
            $manager->flush();

            $this->addFlash("Info", "Create car succeed!");

            return $this->redirectToRoute("managerCars"); 
        }


        return $this->render('car/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/manager/car/update/{id}", name="updateCar")
     */
    public function update(Request $request, $id): Response
    {
        $car = $this->getDoctrine()->getRepository(Car::class)->find($id);

        if ($car == null) {
            $this->addFlash("Error", "Update failed!");
            return $this->redirectToRoute("managerCars");   
        }

        $form = $this->createForm(CarFormType::class, $car); 
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $image = $form->get('ImageFile')->getData();

            if ($image != null) {

                $fileName = md5(uniqid());

                $fileExtension = $image->guessExtension();

                $imageName = $fileName . '.' . $fileExtension;

                try {
                    $image->move(
                        $this->getParameter('images_directory'), $imageName
                    );
                } catch (FileException $e) {

                    return new Response(
                        json_encode(['error' => $e->getMessage()]),
                        Response::HTTP_INTERNAL_SERVER_ERROR,
                        [
                            'content-type' => 'application/json'
                        ]
                    );
                }

                $car->setImage($imageName);
            }

            $manager->persist($car);

            $manager->flush();

            $this->addFlash("Info", "Update car succeed!");

            return $this->redirectToRoute("managerCars"); 
        }


        return $this->render('car/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/manager/car/delete/{id}", name="deleteCar")
     */
    public function delete(Request $request, $id): Response
    {

        $car = $this->getDoctrine()->getRepository(Car::class)->find($id);
        

        if ($car == null) {
            $this->addFlash("Error", "Delete failed!");
            return $this->redirectToRoute("managerCarTypes");   
        }
        $manager = $this->getDoctrine()->getManager();

        $manager->remove($car);

        $manager->flush();
        $this->addFlash("Info", "Delete car succeed !");

        return $this->redirectToRoute("managerCars"); 
    }
}
