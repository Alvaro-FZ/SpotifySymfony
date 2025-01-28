<?php

namespace App\Controller;

use App\Entity\Perfil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class PerfilController extends AbstractController
{
    #[Route('/perfil', name: 'app_perfil')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PerfilController.php',
        ]);
    }


    #[Route('/perfil/new', name: 'app_perfil_crear')]
    public function crearPerfil(EntityManagerInterface $entityManager): JsonResponse
    {
        $perfil = new Perfil();
        $perfil->setFoto("https://i.pinimg.com/736x/57/d9/f0/57d9f011dffce04a5af02cef4a81f551.jpg");
        $perfil->setDescripcion("este es el perfil de ejemplo");

        $entityManager->persist($perfil);
        $entityManager->flush();

        return $this->json([
            'message' => 'perfil creado correctamente.',
            'perfil' => [
                'foto' => $perfil->getFoto(),
                'descripcion' => $perfil->getDescripcion(),
            ],
        ]);
    }
}
