<?php

namespace App\Controller;

use App\Entity\Catastrophe;
use App\Repository\CatastropheRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AffichageController extends AbstractController
{
    #[Route('/affichage', name: 'app_affichage')]
    public function index(): Response
    {
        return $this->render('affichage/index.html.twig', [
            'controller_name' => 'AffichageController',
        ]);
    }

      /**
      * @Route("/view/{slug}",name="view")
      * @Security("is_granted('ROLE_USER')") 
      * @param Catastrophe $catastrophe
      * @return Response
      */
      public function view(Catastrophe $catastrophe,$slug,CatastropheRepository $catastropheRepository){
    
        $catastrophe = $catastropheRepository->findOneBySlug($slug);


        return $this->render('affichage/view.html.twig', [
            'catastrophe' => $catastrophe      
        ]);
    
        


    }

}
