<?php

namespace App\Controller;

use App\Entity\Playlist;
use App\Entity\Usuario;
use App\Repository\PlaylistCancionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class PlaylistController extends AbstractController
{

    #[Route('/playlist/{id}/canciones', name: 'playlist_canciones')]
    public function canciones(int $id, PlaylistCancionRepository $playlistCancionRepository): Response
    {
        $playlistData = $playlistCancionRepository->findCancionesByPlaylist($id);

        if (empty($playlistData)) {
            throw $this->createNotFoundException('Playlist no encontrada');
        }

        // Obtener el nombre de la playlist (ya que todas las canciones tienen la misma playlist)
        $playlistNombre = $playlistData[0]->getPlaylist()->getNombre();

        return $this->render('playlist/canciones.html.twig', [
            'playlistNombre' => $playlistNombre,
            'canciones' => $playlistData
        ]);
    }


    #[Route('/playlist', name: 'app_playlist')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $playlists = $entityManager->getRepository(Playlist::class)->findAll();
        return $this->render('playlist/index.html.twig', ['playlists' => $playlists,]);
    }

    #[Route('/playlist/new', name: 'app_playlist_crear')]
    public function crearPlaylist(EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Usuario::class);
        $usuarioEncontrado = $repository->buscarUsuario(1);
        
        $playlist = new Playlist();
        $playlist->setNombre("playlist 1");
        $playlist->setVisibilidad("privado");
        $playlist->setLikes(60);
        $playlist->setUsuarioPropietario($usuarioEncontrado);

        $entityManager->persist($playlist);
        $entityManager->flush();

        return $this->json([
            'message' => 'playlist creada correctamente.',
            'playlist' => [
                'nombre' => $playlist->getNombre(),
                'visibilidad' => $playlist->getVisibilidad(),
                'likes' => $playlist->getLikes(),
            ],
        ]);
    }
}
