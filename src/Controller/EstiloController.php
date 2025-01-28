<?php

namespace App\Controller;

use App\Entity\Estilo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class EstiloController extends AbstractController
{
    #[Route('/estilo', name: 'app_estilo')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/EstiloController.php',
        ]);
    }


    #[Route('/estilo/new', name: 'app_estilo_crear')]
    public function crearEstilo(EntityManagerInterface $entityManager): JsonResponse
    {
        $estilo = new Estilo();
        $estilo->setNombre("rock");
        $estilo->setDescripcion("puro rock");

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
