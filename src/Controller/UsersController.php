<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Annonces;
use App\Entity\Categories;
use App\Form\AnnoncesType;
use App\Controller\handleRequest;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use App\Entity\Users;
use App\Repository\UsersRepository;
use App\Repository\CategoriesRepository;
use App\Form\EditProfileType;
use App\Repository\AnnoncesRepository;

class UsersController extends AbstractController
{

     /**
     * @Route("/users", name="users_")
     */
    public function acc(): Response
    {
        return $this->render('users/index.html.twig');
    }

/**
     * @Route("/usersliste", name="usersliste")
     */
    public function liste(UsersRepository $users ): Response
    {
        return $this->render('admin/users/index.html.twig',[
            'users' => $users->findAll() ,
        ]);
    }


    /**
     * @Route("/users/annonces", name="users_annonces")
     */
    public function ajoutAnnonces(Request $request): Response
    {
        $annonce = new Annonces;
    
        $form = $this->createForm(AnnoncesType::class, $annonce);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $annonce->setUsers($this->getUser());
            $annonce->setActive(false);

            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();

            $this->addFlash('message','Annonce added');
            return $this->redirectToRoute('users_');
        }
        return $this->render('users/annonces/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/users/modifp", name="users_modifp")
     */
    public function editProfile(Request $request): Response
    {
        $user = $this->getUser(); 

        $form = $this->createForm(EditProfileType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

                $this->addFlash('message',' Profil Updated ');
            return $this->redirectToRoute('users_modifp');
        }
        return $this->render('users/editprofile.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    

    

     

     
}
