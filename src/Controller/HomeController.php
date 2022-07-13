<?php

namespace App\Controller;

use App\Entity\Catastrophe;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CatastropheRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * 
     * @Route("/",name="home")
     * @Security("is_granted('ROLE_USER')") 
     * 
     */
    public function index(EntityManagerInterface $manager,ManagerRegistry $doctrine,Request $request,PaginatorInterface $paginator): Response
    {
        $donnees=$doctrine->getRepository(Catastrophe::class)->findAll();
        $catastrophees= $paginator->paginate(
        $donnees,
        $request->query->getInt('page',1),
            8
        );
        $preventions=$manager->createQuery('SELECT COUNT(p) FROM App\Entity\Prevention p')->getSingleScalarResult();
        $users=$manager->createQuery('SELECT COUNT(u) FROM App\Entity\USer u')->getSingleScalarResult();
        $catastrophes=$manager->createQuery('SELECT COUNT(a) FROM App\Entity\Catastrophe a')->getSingleScalarResult();
        return $this->render('home/index.html.twig', [
            'stats' => compact('users','catastrophes','preventions'),
            'catastrophees' => $catastrophees
        ]);
    }

    /**
     * 
     *@Route("/catastrophe-list", name="catastrophe-list")
     * @Security("is_granted('ROLE_USER')") 
     *
     */
    public function catastropheList(ManagerRegistry $doctrine,Request $request,PaginatorInterface $paginator){

        
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
