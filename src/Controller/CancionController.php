<?php

namespace App\Controller;

use App\Entity\Cancion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class CancionController extends AbstractController
{
    #[Route('/cancion', name: 'app_cancion')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CancionController.php',
        ]);
    }

    #[Route('/cancion/new', name: 'app_cancion_crear')]
    public function crearCancion(EntityManagerInterface $entityManager): JsonResponse
    {
        $cancion = new Cancion();
        $cancion->setTitulo("titulo1");
        $cancion->setDuracion(90);
        $cancion->setAlbum("album1");
        $cancion->setAutor("autor1");
        $cancion->setReproducciones(150);
        $cancion->setLikes(60);

        $entityManager->persist($cancion);
        $entityManager->flush();

        return $this->json([
            'message' => 'cancion creada correctamente.',
            'cancion' => [
                'titulo' => $cancion->getTitulo(),
                'duracion' => $cancion->getDuracion(),
                'album' => $cancion->getAlbum(),
                'autor' => $cancion->getAutor(),
                'reproducciones' => $cancion->getReproducciones(),
                'likes' => $cancion->getLikes(),
            ],
        ]);
    }
}
