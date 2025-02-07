<?php

namespace App\Controller;

use App\Entity\PlaylistCancion;
use App\Entity\Cancion;
use App\Entity\Playlist;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PlaylistCancionController extends AbstractController
{
    #[Route('/playlist/cancion', name: 'app_playlist_cancion')]
    public function index(): Response
    {
        return $this->render('playlist_cancion/index.html.twig', [
            'controller_name' => 'PlaylistCancionController',
        ]);
    }
    
    #[Route('/playlist/cancion/new', name: 'app_playlist_cancion_crear')]
    public function crearPlaylistCancion(EntityManagerInterface $entityManager): Response
    {
        $repositoryPlaylist = $entityManager->getRepository(Playlist::class);
        $playlist = $repositoryPlaylist->buscarPlaylist("playlist 1");

        $repositoryCancion = $entityManager->getRepository(Cancion::class);
        $cancion = $repositoryCancion->buscarCancion("titulo1");
        
        $playlistCancion = new PlaylistCancion();
        $playlistCancion->setPlaylist($playlist);
        $playlistCancion->setCancion($cancion);
        $playlistCancion->setReproducciones(200);

        $entityManager->persist($playlistCancion);
        $entityManager->flush();

        return $this->json([
            'message' => 'playlistCancion creada correctamente.',
            'playlistCancion' => [
                'reproducciones' => $playlistCancion->getReproducciones(),
            ],
        ]);
    }
}
