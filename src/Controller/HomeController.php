<?php

namespace App\Controller;

use App\Repository\CatastropheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
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
    public function index(EntityManagerInterface $manager): Response
    {

        $users=$manager->createQuery('SELECT COUNT(u) FROM App\Entity\USer u')->getSingleScalarResult();
        $catastrophes=$manager->createQuery('SELECT COUNT(a) FROM App\Entity\Catastrophe a')->getSingleScalarResult();
        return $this->render('home/index.html.twig', [
            'stats' => compact('users','catastrophes')
        ]);
    }

    /**
     * 
     *@Route("/catastrophe-list", name="catastrophe-list")
     *
     */
    public function catastropheList(CatastropheRepository $catastropheRepository){

        $catastrophes=$catastropheRepository->findAll();

        return  $this->render('home/catastrophe.html.twig',[
            'catastrophes' => $catastrophes
        ]);

    }
}
