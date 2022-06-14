<?php

namespace App\Controller;

use App\Entity\Images;
use DateTimeImmutable;
use App\Entity\Catastrophe;
use App\Form\CatastropheType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CatastropheRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/catastrophe')]
class CatastropheController extends AbstractController
{
    #[Route('/', name: 'app_catastrophe_index', methods: ['GET'])]
    public function index(CatastropheRepository $catastropheRepository): Response
    {
        return $this->render('catastrophe/index.html.twig', [
            'catastrophes' => $catastropheRepository->findAll(),
        ]);
    }

    /**
     *@Route("/new",name="catastrophe_new", methods={"GET", "POST"})
     *@Security("is_granted('ROLE_USER')") 
     *
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $catastrophe = new Catastrophe();
        $form = $this->createForm(CatastropheType::class, $catastrophe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('images')->getData();
            foreach($images as $image){
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()).'.'.$image->guessExtension();
                
                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                
                // On crée l'image dans la base de données
                $img = new Images();
                $img->setNom($fichier);
                $catastrophe->addImage($img);
            }

            $catastrophe->setCreatedAt(new \DateTimeImmutable());
            $catastrophe->setCatastrophe($this->getUser("user_id"));
            $entityManager->persist($catastrophe);
            $entityManager->flush();
            $this->addFlash('success' ,'Catastrophe Enregistrer avec succeés !');

            return $this->redirectToRoute('home');
        }

        return $this->render('catastrophe/new.html.twig', [
            'catastrophe' => $catastrophe,
            'form' => $form->createView(),
        ]);
    }

     /**
     *@Route("/{id}/edit",name="catastrophes_edit", methods={"GET", "POST"})
     *@Security("is_granted('ROLE_USER')") 
     */
    public function edit(Request $request, Catastrophe $catastrophe,EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CatastropheType::class, $catastrophe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('images')->getData();
    
            // On boucle sur les images
            foreach($images as $image){
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()).'.'.$image->guessExtension();
                
                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                
                // On crée l'image dans la base de données
                $img = new Images();
                $img->setNom($fichier);
                $catastrophe->addImage($img);
            }

            $entityManager->persist($catastrophe);
            $entityManager->flush();

            return $this->redirectToRoute('user');
        }

        return $this->render('catastrophe/edit.html.twig', [
            'catastrophe' => $catastrophe,
            'form' => $form->createView(),
        ]);
    }


     /**
     *@Route("/delete/{id}",name="catastrophes_delete",methods={"POST"})
     *@Security("is_granted('ROLE_USER')") 
     */
    public function delete(Request $request, Catastrophe $catastrophe,EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$catastrophe->getId(), $request->request->get('_token'))) {
            $entityManager->remove($catastrophe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }

 /**
 * @Route("/supprime/image/{id}", name="catastrophes_delete_image", methods={"DELETE"})
 * @Security("is_granted('ROLE_USER')") 
 */
public function deleteImage(Images $image, Request $request, EntityManagerInterface $entityManager){
    $data = json_decode($request->getContent(), true);

    // On vérifie si le token est valide
    if($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token'])){
        // On récupère le nom de l'image
        $nom = $image->getNom();
        // On supprime le fichier
        unlink($this->getParameter('images_directory').'/'.$nom);

        // On supprime l'entrée de la base
        $entityManager->remove($image);
        $entityManager->flush();

        // On répond en json
        return new JsonResponse(['success' => 1]);
    }else{
        return new JsonResponse(['error' => 'Token Invalide'], 400);
    }
}

}
