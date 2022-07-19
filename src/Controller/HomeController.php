<?php

namespace App\Controller;

use App\Entity\Catastrophe;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CatastropheRepository;
use App\Repository\CategorieRepository;
use App\Repository\SouscategorieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * 
     * @Route("/",name="home")
     * @Security("is_granted('ROLE_USER')") 
     * 
     */
    public function index(EntityManagerInterface $manager): Response
    {
      
        $preventions=$manager->createQuery('SELECT COUNT(p) FROM App\Entity\Prevention p')->getSingleScalarResult();
        $users=$manager->createQuery('SELECT COUNT(u) FROM App\Entity\USer u')->getSingleScalarResult();
        $catastrophes=$manager->createQuery('SELECT COUNT(a) FROM App\Entity\Catastrophe a')->getSingleScalarResult();
        return $this->render('home/index.html.twig', [
            'stats' => compact('users','catastrophes','preventions'),
           
        ]);
    }

    /**
     * 
     *@Route("/catastrophe_publier", name="catastrophe_publier")
     * @Security("is_granted('ROLE_USER')") 
     *
     */
    public function catastropheList(Request $request,CatastropheRepository $catastropheRepository){

        
        $propertySearch= new PropertySearch();
        $form= $this->createForm(PropertySearchType::class, $propertySearch);
        $form->handleRequest($request);
        $catastrophes=$catastropheRepository->findAll();
        if($form->isSubmitted() && $form->isValid()){
            $nom= $propertySearch->getNom();

            if($nom !=""){
                $catastrophes=$catastropheRepository->search($nom);

                //dd($catastrophes);
            }else{
                $catastrophes=$catastropheRepository->findAll();
            }
          

        }
          //dd($catastrophes);
        

        return  $this->render('home/catastrophe-list.html.twig',[
            'catastrophes' => $catastrophes,
            'form' =>$form->createView()
           
        ]);

    }
    /**
     * 
     *@Route("/catastrophe_list", name="catastrophe_list")
     * @Security("is_granted('ROLE_USER')") 
     */
    public function catastrophePublier(CatastropheRepository $catastropheRepository,PaginatorInterface $paginator, Request $request,ManagerRegistry $doctrine){
        $donnees=$doctrine->getRepository(Catastrophe::class)->findAll();
        $catastrophes= $paginator->paginate(
        $donnees,
        $request->query->getInt('page',1),
            4
        );
        return  $this->render('home/catastrophe.html.twig',[
            'catastrophes' => $catastrophes
        ]);

    }
}
