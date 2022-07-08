<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Snappy\Pdf;
use App\Entity\User;
use App\Entity\Catastrophe;
use App\Form\EditProfileType;
use App\Repository\UserRepository;
use Symfony\UX\Chartjs\Model\Chart;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CatastropheRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
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
     *@Security("is_granted('ROLE_USER')") 
     */
    public function profileUtilisateur(){

      
      /*  $form=$this->createForm(EditProfileType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $photo=$form->get('imageFile')->getData();
            if($photo){
                $file=md5(uniqid()) . '.' . $photo->guessExtension();

                $photo->move(
                    $this->getParameter('blog_images'), $file
                );

                $user->setImageUser($file);

            }
            $entityManagerInterface->flush();
            $this->addFlash('success','Le profile à été bien modifié');

            return $this->redirectToRoute('home');
        } */

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
        $parPays=$catastropheRepository->findByPays();
        $parNombre=$catastropheRepository->findByNombre();
        $parCategorie=$catastropheRepository->findByCategory();
        $labels= [];
        $labels1=[];
        $data1=[];
        $data=[];
        $color=[];
        $labels2=[];
        $labels3=[];
        $data3=[];
        $data2=[];
       
        foreach($donnees as $donnee){

           $labels[]=$donnee->getCreatedAt()->format('d/m/y');
           $color[]=$donnee->getCouleur();
           $data[]=$donnee->getNombreMort();
          
          
          

        }
         foreach($parNombre as $nombre){

            $labels2[]=$nombre['pays'];
            $data2[]=$nombre['count'];

         }

        foreach($parPays as $items){

            $labels3[]=$items['pays'];
           
            $data3[]=$items['nombreMort'];
            
        }

        foreach($parCategorie as $categories){
            $labels1[]=$categories['categorie'];
            $data1[]=$categories['count'];
        }
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart1=$chartBuilder->createChart(Chart::TYPE_LINE);
        $chart2= $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart3=$chartBuilder->createChart(Chart::TYPE_PIE);

       $chart->setData([
           'labels' => $labels,
           'datasets' => [
               [
                   'label' => 'Nombres de morts par date',
                   'backgroundColor' => $color,
                   'borderColor' => '#BDBDBD',
                   'data' => $data,
               ],
           ],
       ]);
       $chart1->setData([
        'labels' => $labels1,
        'datasets' => [
            [
                'label' => 'Nombre de  catastrophe par categorie',
                'backgroundColor' => '#BDBDBD',
                'borderColor' => '#BDBDBD',
                'data' => $data1,
            ],
        ],
    ]);

       $chart2->setData([
        'labels' => $labels2,
        'datasets' =>[
            [
                'label' => 'Nombre de catastrophes enregistrer par pays',
                'backgroundColor' =>'#BDBDBD',
                'borderColor' => '#fff',
                'data' => $data2
            ],
        ],
    ]);
    
    $chart3->setData([
        'labels' => $labels3,
        'datasets' =>[
            [
                'label' => 'Nombres de morts par pays',
                'backgroundColor' =>'#BDBDBD',
                'borderColor' => '#fff',
                'data' => $data3
            ],
        ],
    ]);
       $chart->setOptions([/** */]);
       $chart1->setOptions([/** */]);
       $chart2->setOptions([/** */]);
       $chart3->setOptions([/** */]);
     
        return $this->render('user/statistique.html.twig',[
            'chart' => $chart,
            'chart1' => $chart1,
            'chart2'=> $chart2,
            'chart3'=> $chart3
           
        ]);

    }

    /**
     * 
     *@Route("/download", name="download") 
     */
    public function pdfPrint(CatastropheRepository $catastrophe,Pdf $knpSnappyPdf){



        $donnees=$catastrophe->findAll();
     
         $html=$this->renderView('user/pdf.html.twig',[
            'donnees' => $donnees
           
        ]);
        return new PdfResponse(
            $knpSnappyPdf->getOutputFromHtml($html),
            'file.pdf'
        );
       

    }

   /**
    * @Route("/test", name="test")
    */
    public function parPays(CatastropheRepository $catastrophe){

        $pays=$catastrophe->findByCategory();

      
       return $this->render('user/test.html.twig',[
       
       'pays' => $pays
       ]);

    }


    
}
