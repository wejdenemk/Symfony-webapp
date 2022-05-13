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


class AccController extends AbstractController
{
    /**
     * @Route("/", name="acc")
     */
    public function index(): Response
    {   
        $repo = $this->getDoctrine()->getRepository(Annonces::class);

        $annonces = $repo->findAll();

        $repoo = $this->getDoctrine()->getRepository(Categories::class);

        $categories= $repoo->findAll();

        return $this->render('acc/index.html.twig',[
            'annonces' => $annonces,
            'categories' => $categories
        ]);
    }
}
