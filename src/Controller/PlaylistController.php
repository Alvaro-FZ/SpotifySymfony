<?php

namespace App\Controller;

use App\Entity\Playlist;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class PlaylistController extends AbstractController
{
    #[Route('/playlist', name: 'app_playlist')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $playlists = $entityManager->getRepository(Playlist::class)->findAll();
        return $this->render('playlist/index.html.twig', ['playlists' => $playlists,]);

        /* return $this->render('playlist/index.html.twig', [
            'controller_name' => 'PlaylistController',
        ]); */
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
