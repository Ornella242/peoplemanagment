<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;


// Toutes mes routes commencent par to/do
#[Route('/todo')]
class ToDoController extends AbstractController
{
   // #[Route('/todo', name: 'app_to_do')]
   /**
    
    * @Route("/", name="app_to_do") 
    */
    public function index(Request $request): Response
    {

        $session = $request ->getSession();
        //afficher notre tableau de ToDo
        //sinon je l'initialise puis l'affiche

        if(!$session->has('todos')){
            $todos = [
              'achat' => 'acheter une clé USB',
              'cours' => 'finaliser mon cours',
              'correction' => 'corriger mes examens'
            ];

            $session->set('todos', $todos);
            $this->addFlash('info', "La liste des todos vient d'être initialisée");
        }
        // si j'ai mon tableau de ToDo dans ma session, je ne fais que l'afficher
   
        return $this->render('to_do/index.html.twig');
    }


    //ajout
    //ajouter les valeurs par défauts avec ? ou avec defaults
    #[Route('/add/{name?test}/{content?tech}', 
             name: 'to_do_add')]
    public function addTodo(Request $request, $name, $content): RedirectResponse{
        $session = $request->getSession();
        // Vérifier si j'ai mon tableau de ToDo dans ma session
            if ($session->has('todos')){
                 //si oui
                    // Vérifier si on a déjà un ToDo avec le même name

                    $todos = $session->get('todos');
                    if(isset($todos[$name])){
                         // Si oui afficher erreur
                        $this->addFlash('error', "Le todo d'id $name existe déjà dans la liste");
                    }else{
                         // Si non on l'ajoute et on affiche un message de succès
                        $todos[$name] = $content;
                        $this->addFlash('success', "Le todo d'id $name a été ajouté avec succès dans la liste");
                        $session->set('todos', $todos);
                    }
  
            }else{
                //si non
                //afficher une erreur et rediriger vers le contôlleur initial 
                $this->addFlash('error', "La liste des todos n'est pas encore initialisée");
            }

            return $this->redirectToRoute('app_to_do');
        
    }

      //modification
      #[Route('/update/{name}/{content}', name: 'to_do_update')]
      public function updateTodo(Request $request, $name, $content): RedirectResponse{
          $session = $request->getSession();
          // Vérifier si j'ai mon tableau de ToDo dans ma session
              if ($session->has('todos')){
                   //si oui
                      // Vérifier si on a déjà un ToDo avec le même name
  
                      $todos = $session->get('todos');
                      if(!isset($todos[$name])){
                           // Si oui afficher erreur
                          $this->addFlash('error', "Le todo d'id $name n'existe pas dans la liste");
                      }else{
                           // Si non on l'ajoute et on affiche un message de succès
                          $todos[$name] = $content;
                          $this->addFlash('success', "Le todo d'id $name a été modifié avec succès dans la liste");
                          $session->set('todos', $todos);
                      }
    
              }else{
                  //si non
                  //afficher une erreur et rediriger vers le contôlleur initial 
                  $this->addFlash('error', "La liste des todos n'est pas encore initialisée");
              }
  
              return $this->redirectToRoute('app_to_do');
          
      }

        //suppression
    #[Route('/delete/{name}', name: 'to_do_delete')]
    public function deleteTodo(Request $request, $name): RedirectResponse{
        $session = $request->getSession();
        // Vérifier si j'ai mon tableau de ToDo dans ma session
            if ($session->has('todos')){
                 //si oui
                    // Vérifier si on a déjà un ToDo avec le même name

                    $todos = $session->get('todos');
                    if(!isset($todos[$name])){
                         // Si oui afficher erreur
                        $this->addFlash('error', "Le todo d'id $name n'existe pas dans la liste");
                    }else{
                         // Si non on le supprime et on affiche un message de succès
                        unset($todos[$name]);
                        $session->set('todos', $todos);
                        $this->addFlash('success', "Le todo d'id $name a été supprimé avec succès dans la liste");
                        
                    }
  
            }else{
                //si non
                //afficher une erreur et rediriger vers le contôlleur initial 
                $this->addFlash('error', "La liste des todos n'est pas encore initialisée");
            }

            return $this->redirectToRoute('app_to_do');
        
    }

    
        //reset
        #[Route('/reset', name: 'to_do_reset')]
        public function resetTodo(Request $request): RedirectResponse{
            $session = $request->getSession();
            $session->remove('todos');
                return $this->redirectToRoute('app_to_do');
            
        }
}
