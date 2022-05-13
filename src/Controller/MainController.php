<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Annonces;
use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Form\FilterType;
use App\Controller\handleRequest;
use App\Entity\Comments;
use App\Form\ContactType;
use App\Form\CommentsType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\AnnoncesRepository;
use App\Repository\CategoriesRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\EditProfileType;
use DateTime;
use DateTimeImmutable;
use Symfony\Component\Mailer\MailerInterface;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(AnnoncesRepository $annoncesRepo ): Response
    {
        return $this->render('main/index.html.twig');
    }


     /**
     * @Route("/main", name="main")
     */
    public function acc(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Annonces::class);

        $annonces = $repo->findAll();

        $repoo = $this->getDoctrine()->getRepository(Categories::class);

        $categories= $repoo->findAll();

        return $this->render('main/aff.html.twig',[
            'annonces' => $annonces,
            'categories' => $categories
        ]);
    }

     /**
     * @Route("/filter/{id}", name="filter")
     */
    public function filter($id): Response
    {

        $repo = $this->getDoctrine()->getRepository(Annonces::class);

        $repoo = $this->getDoctrine()->getRepository(Categories::class);

        $categories= $repoo->findAll();
        return $this->render('main/aff.html.twig', [
            'annonces'=> $repo->findBy(['categories' => $id ]),
            'categories' => $categories

        ]);
    }

     /**
     * @Route("/show/{id}", name="show")
     */
    public function show($id, Request $request){

        $repo = $this->getDoctrine()->getRepository(Annonces::class);

        $annonce = $repo->find($id);

        //comments
        $comment = new Comments;
        $commentForm = $this->createForm(CommentsType::class, $comment);
        $commentForm->handleRequest($request);

        if($commentForm->isSubmitted() && $commentForm->isValid()){
            $comment->setCreatedAt(new DateTimeImmutable());
            $comment->setAnnonces($annonce);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            $this->addFlash('message', 'Votre commentaire ajouter');
            return $this->redirectToRoute('show', ['id' => $annonce->getId()]);
        }

        return $this->render('main/show.html.twig',[
            'annonce'=> $annonce,
            'commentForm'=>$commentForm->createView()
        ]);
    }


    /**
     * @Route("/filterT", name="filterT")
     */
    public function filterT(Request $request): Response
    {
        $repo = $this->getDoctrine()->getRepository(Annonces::class);

        $annonce = new Annonces;
    
        $form = $this->createForm(FilterType::class, $annonce);

        $form->handleRequest($request);

        $option = $form->get('title')->getData();

        if($form->isSubmitted() && $form->isValid()){

            return $this->render('main/testf.html.twig', [
                'form' => $form->createView(), 
         'annonces'=> $repo->findBy(['title' => $option ])]);
        
        }
        return $this->render('main/testf.html.twig', [
            'form' => $form->createView(),
            'annonces'=> $repo->findBy(['title' => $option ])
        ]);
    }

    
/**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);

        $contact = $form->handleRequest($request);
        $f = $contact->get('email')->getData();
        if($form->isSubmitted() && $form->isValid()){
            $email = (new TemplatedEmail())
            ->from($f)
            ->to('no-reply@blog2.test')
            ->subject('Contact depuis lagence')
            ->htmlTemplate('emails/contact.html.twig')
            ->context([
                'mail' => $contact->get('email')->getData(),
                'sujet' => $contact->get('sujet')->getData(),
                'message'=> $contact->get('message')->getData(),
            ])
        ;

        $mailer->send($email);

                $this->addFlash('message', 'One Mail Was Sent');
                return $this->redirectToRoute('contact');
        }

        return $this->render('main/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }


}



