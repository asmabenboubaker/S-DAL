<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Form\MarqueType;
use App\Repository\MarqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
class MarqueController extends AbstractController
{
    
     /**
     * @Route("/marque", name="app_marque_index")
     */
    public function afficherusers   (MarqueRepository $repository){
        $tableusers=$repository->findAll();
        return $this->render('marque/index.html.twig'
            ,['marques'=>$tableusers]);
            

    }
     /**
         * @Route("/ajouterMarque", name="app_marque_new")

     */
    public function ajouterMarque(Request $request)
    {

        $marque  = new Marque ();
        $form= $this->createForm(MarqueType::class,$marque);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){

             
            $new=$form->getData();
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        'back\images',
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $marque->setImage($newFilename);
            }
            $em= $this->getDoctrine()->getManager();
            $em->persist($marque );
            $em->flush();
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute("marque");


        }
        return $this->render("marque/new.html.twig",array("form"=>$form->createView()));
    }
       /**
     * @Route("/supprimermarque/{id}",name="app_marque_delete")
     */
    public function supprimeruser($id,EntityManagerInterface $em ,MarqueRepository $repository){
        $marque=$repository->find($id);
        $em->remove($marque);
        $em->flush();

        return $this->redirectToRoute('app_marque_index');
    }
    /**
     * @Route("/{id}/modifiermarque", name="app_marque_edit", methods={"GET","POST"})
     */
    public function modifieruser(Request $request, Marque $marque): Response
    {
        $form = $this->createForm(MarqueType::class, $marque);


        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        'back\images',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $marque->setImage($newFilename);
            }
            $this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('app_marque_index');
        }

        return $this->render('marque/edit.html.twig', [
            'usermodif' => $marque,
            'form' => $form->createView(),
        ]);
    }

}

