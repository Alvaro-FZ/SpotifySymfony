<?php

namespace App\Controller;

use App\Entity\Cancion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class IndexController extends AbstractController
{
    /* #[Route('/app/interface', name: 'app_interface')]
    public function index(): Response
    {
        return $this->render('app_interface/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    } */

    #[Route('/app/{id}/interface', name: 'index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $canciones = $entityManager->getRepository(Cancion::class)->findAll();
        return $this->render('index/index.html.twig', ['canciones' => $canciones,]);
    }

    #[Route('/app/{id}/enviar', name: 'app_interface_enviarCanciones')]
    public function enviarCanciones(EntityManagerInterface $entityManager): Response
    {
        return $this->render('app_interface/index.html.twig', ['controller_name' => 'IndexController',]);
    }
}
