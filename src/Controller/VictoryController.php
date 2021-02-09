<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VictoryController extends AbstractController
{
    #[Route('/victory', name: 'victory')]
    public function index(): Response
    {
        return $this->render('victory/index.html.twig', [
            'controller_name' => 'VictoryController',
        ]);
    }
}
