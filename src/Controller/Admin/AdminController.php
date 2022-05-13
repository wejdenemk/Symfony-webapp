<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Categories;
use App\Entity\Annonces;
use App\Form\CategoriesType;
use App\Controller\handleRequest;
use App\Repository\UsersRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @Route("/admin", name="admin_")
 * @package App\Controller\Admin
 */

class AdminController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/categoriess", name="categories_ajout")
     */
    public function ajoutCategorie(Request $request): Response
    {
        $categorie = new Categories;

        $form = $this->createForm(CategoriesType::class , $categorie );
 
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            $this->addFlash('message',' Categorie Added');
            return $this->redirectToRoute('adminCa_home');
        }


        return $this->render('admin/categories/ajout.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/categoriessmo/{id}", name="categories_modif")
     */
    public function modifierCategorie(Categories $categorie ,Request $request): Response
    {
        $form = $this->createForm(CategoriesType::class , $categorie );
 
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            $this->addFlash('message','Categorie Updated');
            return $this->redirectToRoute('adminCa_home');
        }
        return $this->render('admin/categories/modif.html.twig',[
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/supprimer/{id}", name="supprimer")
     */
    public function supprimer(Annonces $annonce): Response
    {
            $em = $this->getDoctrine()->getManager();
            $em->remove($annonce);
            $em->flush();

            $this->addFlash('message',' Annonce Deleted');
            return $this->redirectToRoute('adminAn_home');
    }

   /**
     * @Route("/stat", name="usersS")
     */
    public function usersS(UsersRepository $UsersRepo): Response
    {
        
        return $this->render('admin/header.html.twig', [
            'users' => $UsersRepo->findAll() ,
        ]);
    }




    
}
