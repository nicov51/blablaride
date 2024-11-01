<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DriverSpaceController extends AbstractController
{
    #[Route('/driver/space', name: 'app_driver_space')]
    public function index(): Response
    {
        return $this->render('driver_space/index.html.twig', [
            'controller_name' => 'DriverSpaceController',
        ]);
    }
}
