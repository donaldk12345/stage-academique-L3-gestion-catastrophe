<?php

namespace App\Controller;

use App\Entity\Images;
use DateTimeImmutable;
use App\Entity\Catastrophe;
use App\Form\CatastropheType;
use App\Repository\CatastropheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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

    #[Route('/{id}', name: 'app_catastrophe_show', methods: ['GET'])]
    public function show(Catastrophe $catastrophe): Response
    {
        return $this->render('catastrophe/show.html.twig', [
            'catastrophe' => $catastrophe,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_catastrophe_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Catastrophe $catastrophe, CatastropheRepository $catastropheRepository): Response
    {
        $form = $this->createForm(CatastropheType::class, $catastrophe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $catastropheRepository->add($catastrophe);
            return $this->redirectToRoute('app_catastrophe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('catastrophe/edit.html.twig', [
            'catastrophe' => $catastrophe,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_catastrophe_delete', methods: ['POST'])]
    public function delete(Request $request, Catastrophe $catastrophe, CatastropheRepository $catastropheRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$catastrophe->getId(), $request->request->get('_token'))) {
            $catastropheRepository->remove($catastrophe);
        }

        return $this->redirectToRoute('app_catastrophe_index', [], Response::HTTP_SEE_OTHER);
    }
}
