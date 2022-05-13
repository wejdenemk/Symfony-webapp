<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Form\AnnoncesType;
use App\Controller\handleRequest;
use App\Entity\Annonces;
use App\Repository\AnnoncesRepository;
use App\Repository\CategoriesRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @Route("/adminAn", name="adminAn_")
 * @package App\Controller\Admin
 */

class AnnoncesController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(AnnoncesRepository $AnnoRepo): Response
    {
        return $this->render('admin/annonces/index.html.twig', [
            'annonces' => $AnnoRepo->findAll() ,
        ]);
    }

    /**
     * @Route("/activer/{id}", name="activer")
     */
    public function activer(Annonces $annonce) : Response
    {
        $annonce->setActive(($annonce->getActive()) ?false:true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($annonce);
        $em->flush();
       
        return $this->render('admin/annonces/index.html.twig');
    }

    /**
     * @Route("/annonces", name="ajoutAn")
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

            $this->addFlash('message',' Annonce Added');
            return $this->redirectToRoute('adminAn_home');
        }
        return $this->render('admin/annonces/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/annoncemo/{id}", name="modifAn")
     */
    public function modifierAn(Annonces $annonce ,Request $request): Response
    {
        $form = $this->createForm(AnnoncesType::class , $annonce);
 
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();

            $this->addFlash('message',' Annonce updated');
            return $this->redirectToRoute('adminAn_home');
        }
        return $this->render('admin/annonces/modif.html.twig',[
            'form' => $form->createView()
        ]);
    }

    

    
    



}
