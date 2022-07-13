<?php

namespace App\Controller;

use App\Entity\Catastrophe;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\CatastropheRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RechercheController extends AbstractController
{
    /**
     * 
     * @Route("/recherche", name="recherche")
     */
    public function index(Request $request, CatastropheRepository $catastropheRepository,ManagerRegistry $doctrine): Response
    {
        

        $propertySearch= new PropertySearch();
        $form= $this->createForm(PropertySearchType::class, $propertySearch);
        $form->handleRequest($request);
        $catastrophes=$doctrine->getRepository(Catastrophe::class)->findAll();
        if($form->isSubmitted() && $form->isValid()){
            $nom= $propertySearch->getNom();

            if($nom !=""){
                $catastrophes=$catastropheRepository->search($nom);
            }else{
                $catastrophes=$doctrine->getRepository(Produit::class)->findAll();
            }
          
      
        }
     
        return $this->render('recherche/index.html.twig', [
            'form' => $form->createView(),
            'catastrophes'=> $catastrophes
        ]);
    }

    /**
     * @Route("/listescategories", name="listescategories")
     */
    public function gestionCategorie(){

        return $this->render('categorie/dash.html.twig',[

        ]);
    }

}
