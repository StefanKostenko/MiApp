<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class PageController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ManagerRegistry $doctrine): Response
    {   
        
        $repositorio = $doctrine->getRepository(Post::class);
        $posts = $repositorio->findAll();
        return $this->render('page/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/support', name: 'support')]
    public function support(): Response
    {
        return $this->render('page/support.html.twig', []);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(ManagerRegistry $doctrine, Request $request): Response
    {
        $contact = new Contact;
        $form = $this->createForm(ContactFormType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $contact = $form->getData();    
            $entityManager = $doctrine->getManager();    
            $entityManager->persist($contact);
            $entityManager->flush();
            return $this->redirectToRoute('index', []); 
        }
        return $this->render('page/contact.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('page/about.html.twig', []);
    }

    #[Route('/blog', name: 'blog')]
    public function blog(): Response
    {
        return $this->render('page/blog.html.twig', []);
    }
}
