<?php

namespace App\Controller;

use App\Entity\Manufacturer;
use App\Form\ManufacturerFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ManufacturerController extends AbstractController
{
    /**
     * @Route("/manager/manufacturer/create", name="createManufacturer")
     */
    public function create(Request $request): Response
    {
        $manufacturer = new Manufacturer();
        
        $form = $this->createForm(ManufacturerFormType::class, $manufacturer); 
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

                $manufacturer->setLogo($imageName);
            }
            $manager->persist($manufacturer);

            $manager->flush();

            $this->addFlash("Info", "Create manufacturer succeed!");

            return $this->redirectToRoute("managerManufacturers"); 
        }


        return $this->render('manufacturer/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/manager/manufacturer/delete/{id}", name="deleteManufacturer")
     */
    public function delete(Request $request, $id): Response
    {

        $manufacturer = $this->getDoctrine()->getRepository(Manufacturer::class)->find($id);
        

        if ($manufacturer == null) {
            $this->addFlash("Error", "Delete failed!");
            return $this->redirectToRoute("managerManufacturers");   
        }
        $manager = $this->getDoctrine()->getManager();

        $cars = $manufacturer->getCars()->toArray();
        foreach ($cars as $c => $car) {
            $car->setManufacturer(null);
        }

        $manager->remove($manufacturer);

        $manager->flush();
        $this->addFlash("Info", "Delete manufacturer succeed!");

        return $this->redirectToRoute("managerManufacturers"); 
    }

    /**
     * @Route("/manager/manufacturer/update/{id}", name="updateManufacturer")
     */
    public function update(Request $request, $id): Response
    {

        $manufacturer = $this->getDoctrine()->getRepository(Manufacturer::class)->find($id);
        

        if ($manufacturer == null) {
            $this->addFlash("Error", "Update failed!");
            return $this->redirectToRoute("managerManufacturers");   
        }

        $form = $this->createForm(ManufacturerFormType::class, $manufacturer); 
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $manager->persist($manufacturer);

            $manager->flush();

            $this->addFlash("Info", "Update manufacturer succeed!");

            return $this->redirectToRoute("managerManufacturers");  
        }


        return $this->render('manufacturer/update.html.twig', [
            'form' => $form->createView()
        ]);
       
    }
}
