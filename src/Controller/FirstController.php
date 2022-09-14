<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Request;


class FirstController extends AbstractController
{
    #[Route('/template', name: 'template')]
    public function template(){
        return $this->render('template.html.twig');
    }

    #[Route('/order/{maVar}', name: 'test.order.route')]
    public function testOrderRoute($maVar): Response
    {
  
        return new Response ("<html><body>$maVar</body></html>");
    }

    #[Route('/first', name: 'app_first')]
    public function index(): Response
    {
  
        //chercher au niveau de la bdd vos users
        return $this->render('first/index.html.twig', [
            'name' => 'Mirlande',
            'firstname' => 'AHDO',
        ]);
    }

   // #[Route('/sayhello/{name}/{firstname}', name: 'say.hello')]
    public function sayhello($name, $firstname): Response
    {
      
        return $this->render('first/hello.html.twig',[
          'nom' => $name,
          'prenom' => $firstname
       
       ]);
    }

    //pour dire que ce sont des entiers <\d+>
    #[Route('/multi/{entier1<\d+>}/{entier2<\d+>}', name : 'multiplication')]
    public function multiplication( $entier1, $entier2): Response
    {
      $resultat = $entier1 * $entier2; 
        return new Response("<h1>$resultat</h1>");
    }
}
