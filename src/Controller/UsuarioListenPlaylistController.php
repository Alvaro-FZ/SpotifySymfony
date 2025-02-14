<?php

namespace App\Controller;

use App\Entity\UsuarioListenPlaylist;
use App\Entity\Usuario;
use App\Entity\Playlist;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UsuarioListenPlaylistController extends AbstractController
{
    #[Route('/usuario/listen/playlist', name: 'app_usuario_listen_playlist')]
    public function index(): Response
    {
        return $this->render('usuario_listen_playlist/index.html.twig', [
            'controller_name' => 'UsuarioListenPlaylistController',
        ]);
    }

    #[Route('/usuario/listen/playlist/new', name: 'app_usuario_listen_playlist_crear')]
    public function crearUsuarioListenPlaylist(EntityManagerInterface $entityManager): Response
    {
        $repositoryPlaylist = $entityManager->getRepository(Playlist::class);
        $playlist = $repositoryPlaylist->buscarPlaylist("playlist 1");

        $repositoryUsuario = $entityManager->getRepository(Usuario::class);
        $usuario = $repositoryUsuario->buscarUsuario(1);
        
        $usuarioListenPlaylist = new UsuarioListenPlaylist();
        $usuarioListenPlaylist->setPlaylist($playlist);
        $usuarioListenPlaylist->setUsuario($usuario);

        $entityManager->persist($usuarioListenPlaylist);
        $entityManager->flush();

        return $this->json([
            'message' => 'usuarioListenPlaylist creada correctamente.',
            'usuarioListenPlaylist' => [
            ],
        ]);
    }
}
