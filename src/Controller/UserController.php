<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Catastrophe;
use App\Repository\UserRepository;
use Symfony\UX\Chartjs\Model\Chart;
use App\Repository\CatastropheRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * 
     * @Route("/user/{slug}",name="user")
     * @Security("is_granted('ROLE_USER')") 
     */
    public function userProfile(User $user,CatastropheRepository $catastropheRepository): Response
    {
        $catastrophes=$catastropheRepository->findAll();
       
        return $this->render('user/index.html.twig', [
            'user' => $user,
            'catastrophes' => $catastrophes
            
        ]);
    }
    /**
     * 
     *@Route("/utilisateurs", name="utilisateurs")
     *@Security("is_granted('ROLE_ADMIN')") 
     */
    public function listeUtilisateur(UserRepository $userRepository){

        $users=$userRepository->findAll();

        return $this->render('user/user.html.twig',[
            'users'=>$users
        ]);


    }
     /**
     * 
     *@Route("/profile", name="profile")
     *@Security("is_granted('ROLE_ADMIN')") 
     */
    public function profileUtilisateur(){

  

        return $this->render('user/profile.html.twig',[
           
        ]);


    }
    
    /**
     * 
     *@Route("/statistique", name="statistique")
     *@Security("is_granted('ROLE_ADMIN')") 
     */
    public function statistique(CatastropheRepository $catastropheRepository,ChartBuilderInterface $chartBuilder){
        
        $donnees=$catastropheRepository->findByDate();
        $labels= [];
        $data=[];
        $color=[];
       
        foreach($donnees as $donnee){

           $labels[]=$donnee->getCreatedAt()->format('d/m/y');
           $color[]=$donnee->getCouleur();
           $data[]=$donnee->getNombreMort();
          
          
          

        }
        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);

       $chart->setData([
           'labels' => $labels,
           'datasets' => [
               [
                   'label' => 'Catastrophes',
                   'backgroundColor' => $color,
                   'borderColor' => '#F7F7F7',
                   'data' => $data,
               ],
           ],
       ]);
       $chart->setOptions([/** */]);
     
        return $this->render('user/statistique.html.twig',[
            'chart' => $chart
           
        ]);

    }
    
}
