<?php

namespace App\Controller;

use App\Entity\Tile;
use App\Repository\BoatRepository;
use App\Repository\TileRepository;
use App\Services\MapManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MapController extends AbstractController
{
    /**
     * @Route("/map", name="map")
     */
    public function displayMap(BoatRepository $boatRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $tiles = $em->getRepository(Tile::class)->findAll();

        foreach ($tiles as $tile) {
            $map[$tile->getCoordX()][$tile->getCoordY()] = $tile;
        }

        $boat = $boatRepository->findOneBy([]);

        return $this->render('map/index.html.twig', [
            'map'  => $map ?? [],
            'boat' => $boat,
        ]);
    }

    /**
     * @Route("/start", name="start")
     */
    public function start(
        BoatRepository $boatRepository,
        TileRepository $tileRepository,
        EntityManagerInterface $entityManager,
        MapManager $mapManager
    ): Response {
        $boat = $boatRepository->findOneBy([]);
        $boat
            ->setCoordX(0)
            ->setCoordY(0);

        $tile = $tileRepository->findOneBy([
            'hasTreasure' => true,
        ]);
        if ($tile) {
            $tile->setHasTreasure(false);
        }
        $mapManager->getRandomIsland()->setHasTreasure(true);

        $entityManager->flush();

        return $this->redirectToRoute('map');
    }
}
