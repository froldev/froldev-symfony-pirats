<?php

namespace App\Controller;

use App\Entity\Boat;
use App\Form\BoatType;
use App\Services\MapManager;
use App\Repository\BoatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/boat")
 */
class BoatController extends AbstractController
{
    const NORTH = "N";
    const SOUTH = "S";
    const EAST = "E";
    const WEST = "W";

    const DIRECTIONS = [
        self::NORTH,
        self::SOUTH,
        self::EAST,
        self::WEST,
    ];

    /**
     * @Route("/direction/{direction}", name="moveDirectionBoat")
     */
    public function moveDirection(
        string $direction,
        BoatRepository $boatRepository,
        EntityManagerInterface $entityManager,
        MapManager $mapManager
    ): Response {
        if (!in_array($direction, self::DIRECTIONS)) {
            throw $this->createNotFoundException('Cette direction n\'existe pas !');
        }

        $boat = $boatRepository->findOneBy([]);

        switch ($direction) {
            case self::NORTH:
                $boat->setCoordY($boat->getCoordY() - 1);
                break;
            case self::SOUTH:
                $boat->setCoordY($boat->getCoordY() + 1);
                break;
            case self::EAST:
                $boat->setCoordX($boat->getCoordX() + 1);
                break;
            case self::WEST:
                $boat->setCoordX($boat->getCoordX() - 1);
                break;
        }

        if ($mapManager->tileExists($boat->getCoordX(), $boat->getCoordY())) {
            $entityManager->flush();
        }

        if ($mapManager->checkTreasure($boat)) {
            return new JsonResponse([
                'message' => 'success',
            ]);
        }

        return new JsonResponse([
            'message' => 'move',
            'x' => $boat->getCoordX(),
            'y' => $boat->getCoordY(),
        ]);
    }
}
