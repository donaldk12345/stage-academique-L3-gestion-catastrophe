<?php

namespace App\Controller;

use App\Entity\Prevention;
use App\Entity\Catastrophe;
use App\Form\PreventionFormType;
use App\Repository\PaysRepository;
use App\Repository\ContinentRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CatastropheRepository;
use App\Repository\CategorieRepository;
use App\Repository\PreventionRepository;
use App\Repository\SouscategorieRepository;
use Symfony\Component\HttpFoundation\Request;
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
      public function view(Catastrophe $catastrophe,$slug,CatastropheRepository $catastropheRepository,Request $request,EntityManagerInterface $entityManagerInterface){
        $catastrophe=$catastropheRepository->findOneBy(['slug'=> $slug]);

        $prevention= new Prevention();
        $form=$this->createForm(PreventionFormType::class, $prevention);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $prevention->setCreatedAt(new \DateTimeImmutable())
            ->setPrevent($this->getUser())
            ->setCatastrophe($catastrophe);
            $entityManagerInterface->persist($prevention);
            //dd($prevention);
            $entityManagerInterface->flush();
            return $this->redirectToRoute(
                'view',['slug'=> $catastrophe->getSlug()]
            );

        }
        $catastrophe = $catastropheRepository->findOneBySlug($slug);



        return $this->render('affichage/view.html.twig', [
            'catastrophe' => $catastrophe ,
            'form'=>$form->createView()     
        ]);
    
        


    }

    /**
     *@Route("/listespays", name="listespays" ) 
     */ 
    public function listPays(PaysRepository $paysRepository){

        $pays=$paysRepository->findAll();
        //dd($pays);
        return $this->render('pays/pays.html.twig', [
            'pays' => $pays
                 
        ]);

    }
    /**
     *@Route("/listescontinent", name="listescontinent" ) 
     */ 
    public function listContinent(ContinentRepository $continentRepository){

        $continents=$continentRepository->findAll();
        //dd($pays);
        return $this->render('continent/continent.html.twig', [
            'continents' => $continents
                 
        ]);

    }

    /**
     *@Route("/listesSousCategorie", name="listesSousCategorie" ) 
     */ 
    public function listSouscategorie(SouscategorieRepository $souscategorieRepository){

        $sousCategories=$souscategorieRepository->findAll();
        //dd($pays);
        return $this->render('souscategorie/souscategorie.html.twig', [
            'sousCategories' => $sousCategories
                 
        ]);

    }
     /**
     *@Route("/listescategorie", name="listescategorie" ) 
     */ 
    public function listCategorie(CategorieRepository $catastropheRepository){

        $categories=$catastropheRepository->findAll();
        //dd($pays);
        return $this->render('categorie/categorie.html.twig', [
            'categories' => $categories
                 
        ]);

    }

    /**
     *@Route("/listesprevention", name="listesprevention" ) 
     */ 
    public function listPrevention(PreventionRepository $preventionRepository){

        $preventions=$preventionRepository->findAll();
        //dd($pays);
        return $this->render('home/prevention.html.twig', [
            'preventions' => $preventions
                 
        ]);

    }

      

}
