<?php

namespace App\Controller;

use App\Entity\Playlist;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class PlaylistController extends AbstractController
{
    #[Route('/playlist', name: 'app_playlist')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PlaylistController.php',
        ]);
    }


    #[Route('/playlist/new', name: 'app_playlist_crear')]
    public function crearPlaylist(EntityManagerInterface $entityManager): JsonResponse
    {
        $playlist = new Playlist();
        $playlist->setNombre("playlist1");
        $playlist->setVisibilidad("publico");
        $playlist->setReproducciones(200);
        $playlist->setLikes(34);

        $entityManager->persist($playlist);
        $entityManager->flush();

        return $this->json([
            'message' => 'playlist creada correctamente.',
            'playlist' => [
                'nombre' => $playlist->getNombre(),
                'visibilidad' => $playlist->getVisibilidad(),
                'reproducciones' => $playlist->getReproducciones(),
                'likes' => $playlist->getLikes(),
            ],
        ]);
    }
}
