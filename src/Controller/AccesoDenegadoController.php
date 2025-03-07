<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccesoDenegadoController extends AbstractController
{
    #[Route('/acceso_denegado', name: 'app_acceso_denegado')]
    public function index(): Response
    {
        return $this->render('acceso_denegado/index.html.twig', [
            'controller_name' => 'AccesoDenegadoController',
        ]);
    }
}
