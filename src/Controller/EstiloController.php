<?php

namespace App\Controller;

use App\Entity\Estilo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EstiloController extends AbstractController
{
    #[Route('/estilo', name: 'app_estilo')]
    public function index(): Response
    {
        return $this->render('estilo/index.html.twig', [
            'controller_name' => 'EstiloController',
        ]);
    }

    #[Route('/estilo/new', name: 'app_estilo_crear')]
    public function createEstilo(EntityManagerInterface $entityManager): Response
    {
        $estilo = new Estilo();
        $estilo->setNombre("rock");
        $estilo->setDescripcion("puro rock!");

        $entityManager->persist($estilo);
        $entityManager->flush();

        return $this->json([
            'message' => 'estilo creado correctamente.',
            'estilo' => [
                'nombre' => $estilo->getNombre(),
                'descripcion' => $estilo->getDescripcion(),
            ],
        ]);
    }
}
