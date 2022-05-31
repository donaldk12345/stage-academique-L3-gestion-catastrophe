<?php

namespace App\Controller;

use App\Entity\Souscategorie;
use App\Form\SouscategorieType;
use App\Repository\SouscategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/souscategorie')]
class SouscategorieController extends AbstractController
{
    #[Route('/', name: 'app_souscategorie_index', methods: ['GET'])]
    public function index(SouscategorieRepository $souscategorieRepository): Response
    {
        return $this->render('souscategorie/index.html.twig', [
            'souscategories' => $souscategorieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_souscategorie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SouscategorieRepository $souscategorieRepository): Response
    {
        $souscategorie = new Souscategorie();
        $form = $this->createForm(SouscategorieType::class, $souscategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $souscategorieRepository->add($souscategorie, true);

            return $this->redirectToRoute('app_souscategorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('souscategorie/new.html.twig', [
            'souscategorie' => $souscategorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_souscategorie_show', methods: ['GET'])]
    public function show(Souscategorie $souscategorie): Response
    {
        return $this->render('souscategorie/show.html.twig', [
            'souscategorie' => $souscategorie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_souscategorie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Souscategorie $souscategorie, SouscategorieRepository $souscategorieRepository): Response
    {
        $form = $this->createForm(SouscategorieType::class, $souscategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $souscategorieRepository->add($souscategorie, true);

            return $this->redirectToRoute('app_souscategorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('souscategorie/edit.html.twig', [
            'souscategorie' => $souscategorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_souscategorie_delete', methods: ['POST'])]
    public function delete(Request $request, Souscategorie $souscategorie, SouscategorieRepository $souscategorieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$souscategorie->getId(), $request->request->get('_token'))) {
            $souscategorieRepository->remove($souscategorie, true);
        }

        return $this->redirectToRoute('app_souscategorie_index', [], Response::HTTP_SEE_OTHER);
    }
}
