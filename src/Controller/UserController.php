<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Catastrophe;
use App\Repository\CatastropheRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
}
