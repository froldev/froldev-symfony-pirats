<?php

namespace App\Controller;

use App\Entity\Tile;
use App\Form\TileType;
use App\Repository\TileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tile')]
class TileController extends AbstractController
{
    #[Route('/', name: 'tile_index', methods: ['GET'])]
    public function index(TileRepository $tileRepository): Response
    {
        return $this->render('tile/index.html.twig', [
            'tiles' => $tileRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'tile_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $tile = new Tile();
        $form = $this->createForm(TileType::class, $tile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tile);
            $entityManager->flush();

            return $this->redirectToRoute('tile_index');
        }

        return $this->render('tile/new.html.twig', [
            'tile' => $tile,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'tile_show', methods: ['GET'])]
    public function show(Tile $tile): Response
    {
        return $this->render('tile/show.html.twig', [
            'tile' => $tile,
        ]);
    }

    #[Route('/{id}/edit', name: 'tile_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tile $tile): Response
    {
        $form = $this->createForm(TileType::class, $tile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tile_index');
        }

        return $this->render('tile/edit.html.twig', [
            'tile' => $tile,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'tile_delete', methods: ['DELETE'])]
    public function delete(Request $request, Tile $tile): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tile->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tile);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tile_index');
    }
}
