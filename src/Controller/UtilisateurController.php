<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\AjoutuserType;
use App\Form\InscriptionType;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('utilisateur/home.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
    /**
     * @Route("/userinfo", name="userinfo")
     */
    public function userinfo(): Response
    {
        return $this->render('utilisateur/userinfo.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    /**
     * @Route("/usermodif", name="usermodif")
     */
    public function usermodif(): Response
    {
        return $this->render('utilisateur/usermodif.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    /**
     * @Route("/inscription", name="inscription")
     * @param Request $request
     * @param $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function inscription(Request $request, UserPasswordEncoderInterface $passwordEncoder,\Swift_Mailer $mailer): Response
    {

        $bool=false;
        $Utilisateur  = new Utilisateur ();

        $form= $this->createForm(InscriptionType::class,$Utilisateur);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            if (true === $form['agreeTerms']->getData()) {
                
           
          $Utilisateur->setRole("Client");
            $Utilisateur->setMdp(
                $passwordEncoder->encodePassword($Utilisateur,
                    $form->get('mdp')->getData()
                )
            );


            $em= $this->getDoctrine()->getManager();
            $em->persist($Utilisateur );
            $em->flush();
            $this->getDoctrine()->getManager()->flush();
$msg = $Utilisateur->getNom();
            $message = (new \Swift_Message("Bienvenue à ADL".$msg))

                ->setFrom('eventum20@gmail.com')
                ->setTo('asmaboubaker11@gmail.com')
                //message avec vue twig
                ->setBody(
                    $this->renderView(
                        'email/contact.html.twig'
                    ),
                    'text/html'
                ) ;

            $mailer->send($message);
 

            return $this->redirectToRoute("login");
                }
                
        }
        return $this->render("utilisateur/inscription.html.twig",array("form"=>$form->createView()));
    }


    /**
     * @Route("/login", name="login")
     */
    public function login(): Response
    {
        return $this->render('security/login.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }







    /**
         * @Route("/ajouterUtilisateur", name="ajouterUtilisateur")

     */
    public function ajouterUtilisateur(Request $request)
    {

        $Utilisateur  = new Utilisateur ();
        $form= $this->createForm(UtilisateurType::class,$Utilisateur);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){

            /*     $Utilisateur->setMdp(
                     $passwordEncoder->encodePassword($Utilisateur,
                         $form->get('utilisateurmdp')->getData()
                     )
                 );
     */
            $new=$form->getData();
            $imageFile = $form->get('imageuser')->getData();
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
                $Utilisateur->setImageuser($newFilename);
            }
            $em= $this->getDoctrine()->getManager();
            $em->persist($Utilisateur );
            $em->flush();
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute("afficherusers");


        }
        return $this->render("utilisateur/ajouterutilisateur.html.twig",array("form"=>$form->createView()));
    }

    

    /**
     * @Route("/supprimeruser/{id}",name="supprimeruser")
     */
    public function supprimeruser($id,EntityManagerInterface $em ,UtilisateurRepository $repository){
        $user=$repository->find($id);
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('app_admin');
    }

    /**
     * @Route("/{id}/modifieruser", name="modifieruser", methods={"GET","POST"})
     */
    public function modifieruser(Request $request, Utilisateur $user): Response
    {
        $form = $this->createForm(UtilisateurType::class, $user);


        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageuser')->getData();
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
                $user->setImageuser($newFilename);
            }
            $this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('app_admin');
        }

        return $this->render('utilisateur/modifierutilisateur.html.twig', [
            'usermodif' => $user,
            'form' => $form->createView(),
        ]);
    }




}
