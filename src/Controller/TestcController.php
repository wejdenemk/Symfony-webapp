<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Annonces;
use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Controller\handleRequest;
use App\Repository\AnnoncesRepository;
use App\Repository\CategoriesRepository;
use Doctrine\Persistence\ManagerRegistry;
use SessionIdInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TestcController extends AbstractController
{
    /**
     * @Route("/testc", name="testc")
     */
    public function index(SessionInterface $session, AnnoncesRepository $annoncesRepository): Response
    {
        $panier = $session->get('panier',[]);
        
        $panierWithData = [];
    
        foreach($panier as $id => $quantity){
            $panierWithData[] = [
                "annonce"=> $annoncesRepository->find($id),
                "quantity"=> $quantity
            ];

        }

        $total = 0;
        foreach($panierWithData as $item ){
           $totalItem = $item['annonce']->getPrix()* $item['quantity'];
           $total += $totalItem;
        }


        return $this->render('testc/test.html.twig',[
            'items' => $panierWithData,
            'total' => $total
        ]);
    }


    /**
     * @Route("/addtest/{id}", name="addtest")
     */
    public function add($id, SessionInterface $session )
    {   

        $panier = $session->get('panier', []);

        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }
        
        $session->set('panier',$panier);

        $this->addFlash('message','One Article Added To Chart');
        return $this->redirectToRoute('main');
       
        return $this->redirectToRoute("main");
    }



    /**
     * @Route("/addtest2/{id}", name="addtest2")
     */
    public function add2($id, SessionInterface $session )
    {   

        $panier = $session->get('panier', []);

        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }
        
        $session->set('panier',$panier);

        $this->addFlash('message','One Article Added To Chart');
        return $this->redirectToRoute('acc');
       
        return $this->redirectToRoute("acc");
    }

     /**
     * @Route("/addtest3/{id}", name="addtest3")
     */
    public function add3($id, SessionInterface $session )
    {   

        $panier = $session->get('panier', []);

        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }
        
        $session->set('panier',$panier);
       
        return $this->redirectToRoute("testc");
    }






     /**
     * @Route("/remove/{id}", name="remove")
     */
    public function removee($id, SessionInterface $session): Response
    {   
        $panier = $session->get('panier');

        if(!empty($panier[$id])){
            if($panier[$id] > 1){
               $panier[$id]--; 
            }else{
                unset($panier[$id]);
            }}

        $session->set('panier',$panier);

        return $this->redirectToRoute('testc');
    }



    
    /**
     * @Route("/removetest/{id}", name="removetest")
     */
    public function remove($id, SessionInterface $session ): Response
    {   
        $panier = $session->get('panier', []);

        if(!empty($panier[$id])){
           unset($panier[$id]);
        }
        $session->set('panier',$panier);

        return $this->redirectToRoute("testc");
    }


     /**
     * @Route("/deleteAll", name="deleteAll")
     */
    public function deleteall(SessionInterface $session): Response
    {   
        $panier = $session->set('panier',[]);

        return $this->redirectToRoute('testc');
    }



}
