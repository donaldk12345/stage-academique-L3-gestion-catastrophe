<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\User;
use App\Entity\Catastrophe;
use App\Repository\UserRepository;
use Symfony\UX\Chartjs\Model\Chart;
use App\Repository\CatastropheRepository;
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
        $labels2=[];
        $labels3=[];
       
        foreach($donnees as $donnee){

           $labels[]=$donnee->getCreatedAt()->format('d/m/y');
           $labels2[]=$donnee->getSousCategorie()->getNom();
           $labels3[]=$donnee->getPays()->getNom();
           $color[]=$donnee->getCouleur();
           $data[]=$donnee->getNombreMort();
          
          
          

        }
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
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

       $chart2->setData([
        'labels' => $labels2,
        'datasets' =>[
            [
                'label' => 'Nombres de morts par type de catastrophe',
                'backgroundColor' =>$color,
                'borderColor' => '#fff',
                'data' => $data
            ],
        ],
    ]);
    
    $chart3->setData([
        'labels' => $labels3,
        'datasets' =>[
            [
                'label' => 'Nombres de morts par pays',
                'backgroundColor' =>$color,
                'borderColor' => '#fff',
                'data' => $data
            ],
        ],
    ]);
       $chart->setOptions([/** */]);
       $chart2->setOptions([/** */]);
       $chart3->setOptions([/** */]);
     
        return $this->render('user/statistique.html.twig',[
            'chart' => $chart,
            'chart2'=> $chart2,
            'chart3'=> $chart3
           
        ]);

    }

    /**
     * 
     *@Route("/download", name="download") 
     */
    public function pdfPrint(CatastropheRepository $catastrophe){



        $donnees=$catastrophe->findAll();

        $pdfOptions= new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);
        $dompdf= new Dompdf($pdfOptions);
        $context= stream_context_create([
          'ssl'=> [
            'verify_peer'=> FALSE,
            'verify_peer_name'=> FALSE,
            'allow_self_signed'=>TRUE
          ]
          ]);
          $dompdf->setHttpContext($context);
     
         $html=$this->renderView('user/pdf.html.twig',[
            'donnees' => $donnees
           
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4','portrait');
        $dompdf->render();
  
        $fichier='statistique-data-'.'.pdf';
        $dompdf->stream($fichier, [
        'Attachment' => true
        ]);
        return new Response();
  

    }


    
}
