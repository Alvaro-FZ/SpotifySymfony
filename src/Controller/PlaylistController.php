<?php

namespace App\Controller;

use App\Entity\Playlist;
use App\Entity\User;
use App\Repository\PlaylistCancionRepository;
use App\Entity\PlaylistCancion;
use App\Form\PlaylistType;
use App\Repository\PlaylistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class PlaylistController extends AbstractController
{

    #[Route('/playlist/{id}/canciones', name: 'playlist_canciones')]
    public function canciones(AuthenticationUtils $authenticationUtils, int $id, PlaylistCancionRepository $playlistCancionRepository, LoggerInterface $logger): Response
    {
        $playlistData = $playlistCancionRepository->findCancionesByPlaylist($id);

        if (empty($playlistData)) {
            throw $this->createNotFoundException('Playlist no encontrada o está vacía');
        }

        // Obtener el nombre de la playlist (ya que todas las canciones tienen la misma playlist)
        $playlistNombre = $playlistData[0]->getPlaylist()->getNombre();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $logger->notice('## Usuario ' . $lastUsername . ' Entró en la playlist "' . $playlistNombre . '".');

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
    #[IsGranted('ROLE_USUARIO')]
    public function crearPlaylist(
        AuthenticationUtils $authenticationUtils,
        Request $request,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger
    ): Response {
        // Verificamos si el usuario tiene permisos
        

        // Obtén el usuario actual
        $usuarioActual = $this->getUser();

        // Verifica que el usuario esté autenticado
        if (!$usuarioActual) {
            $this->addFlash('error', 'Debes estar autenticado para crear una playlist.');
            return $this->redirectToRoute('app_login'); // Redirige al login si no está autenticado
        }

        $playlist = new Playlist();
        $form = $this->createForm(PlaylistType::class, $playlist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Asigna el usuario actual como propietario de la playlist
            $playlist->setUsuarioPropietario($usuarioActual);

            $entityManager->persist($playlist);
            $entityManager->flush();

            $canciones = $form->get('canciones')->getData();
            foreach ($canciones as $cancion) {
                $playlistCancion = new PlaylistCancion();
                $playlistCancion->setPlaylist($playlist);
                $playlistCancion->setCancion($cancion);
                $playlistCancion->setReproducciones(0);
                $entityManager->persist($playlistCancion);
            }

            $entityManager->flush();

            $this->addFlash('success', 'Playlist creada correctamente con ' . count($canciones) . ' canciones.');

            $lastUsername = $authenticationUtils->getLastUsername();
            $logger->notice('## Usuario ' . $lastUsername . ' Creó una nueva playlist: "' . $form->get('nombre')->getData() . '".');
            return $this->redirectToRoute('app_playlist');
        }

        return $this->render('playlist/crearPlaylist.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/mis-playlists', name: 'mis_playlists')]
    #[IsGranted('ROLE_USUARIO')]
    public function misPlaylists(PlaylistRepository $playlistRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', 'Debes iniciar sesión para ver tus playlists');
            return $this->redirectToRoute('app_login');
        }

        $misPlaylists = $playlistRepository->findBy([
            'usuarioPropietario' => $user
        ]);

        return $this->render('playlist/mis_playlist.html.twig', [
            'playlists' => $misPlaylists
        ]);
    }


    // Funciona cuando id es public
    /* #[Route('/mis-playlists', name: 'mis_playlists')]
    #[IsGranted('ROLE_USUARIO')]
    public function misPlaylists(AuthenticationUtils $authenticationUtils, PlaylistRepository $playlistRepository, LoggerInterface $logger): Response
    {
        // Obtén el usuario autenticado directamente con getUser()
        $usuario = $this->getUser(); // El usuario autenticado

        // Si el usuario no está autenticado, puedes redirigir o lanzar una excepción
        if (!$usuario) {
            throw $this->createAccessDeniedException('Acceso denegado. No estás autenticado.');
        }
        
        $usuarioId = $usuario->id; // Aquí puedes acceder a getId() sin problemas

        // Busca las playlists usando el ID del usuario
        $misPlaylists = $playlistRepository->findByUsuarioPropietarioId($usuarioId);

        $lastUsername = $authenticationUtils->getLastUsername();
        $logger->notice('## Usuario ' . $lastUsername . ' con id: ' . $usuarioId . ' Entró en "mis playlist".');

        return $this->render('playlist/mis_playlist.html.twig', [
            'playlists' => $misPlaylists
        ]);
    } */

    /* #[Route('/misPlaylists', name: 'mis_playlists')]
    #[AttributeIsGranted('ROLE_USUARIO')]
    public function misPlaylists(AuthenticationUtils $authenticationUtils, PlaylistRepository $playlistRepository, LoggerInterface $logger): Response
    {
        $user = $this->getUser(); // Obtén el usuario actual
        $userId = $user->getUserIdentifier(); // Obtén el ID del usuario actual

        // Busca las playlists usando el ID del usuario
        $misPlaylists = $playlistRepository->findByUsuarioPropietarioId($userId);

        $lastUsername = $authenticationUtils->getLastUsername();
        $logger->notice('## Usuario ' . $lastUsername . ' Entró en "mis playlist".');

        return $this->render('playlist/mis_playlist.html.twig', [
            'misPlaylists' => $misPlaylists
        ]);
    } */
}
