<?php

namespace App\Controller;

use App\Entity\User;
use DateTimeImmutable;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration",methods={"GET", "POST"})
     */
    public function registration(Request $request, EntityManagerInterface $manager,UserPasswordHasherInterface $passwordHasher)
    {
        $user = new User();
        $form= $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $hash = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setCreatedAt(new \DateTimeImmutable());
            $user->setRoles(['ROLE_USER']);
          
            $manager->persist($user);
            
            $manager->flush();
            /*$email =(new Email())
              ->from('fotsoyvesdonald@gmail.com')
              ->to($user->getEmail())
              ->subject('Bienvenue sur le site')
              ->text("Merci pour votre Insciption {$user->getUserName()} ");
            $mailer->send($email);*/
           
            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/connexion", name="security_login",methods={"GET", "POST"})
     * 
     */
    public function login(){

        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout(){

    }
}
