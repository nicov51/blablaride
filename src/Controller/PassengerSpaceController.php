<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PassengerSpaceController extends AbstractController
{
    #[Route('/passenger/space', name: 'app_passenger_space')]
    public function index(): Response
    {
        return $this->render('passenger_space/index.html.twig', [
            'controller_name' => 'PassengerSpaceController',
        ]);
    }
}
