<?php

namespace App\Controller;

use App\Entity\Playlist;
use App\Entity\Usuario;
use App\Repository\PlaylistCancionRepository;
use App\Entity\PlaylistCancion;
use App\Form\PlaylistType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted as AttributeIsGranted;

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

    /* #[Route('/playlist/new', name: 'app_playlist_crear')]
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
    } */

    #[AttributeIsGranted('ROLE_USUARIO')]
    #[Route('/playlist/new', name: 'app_playlist_crear')]
    public function crearPlaylist(Request $request, EntityManagerInterface $entityManager): Response
    {
        $playlist = new Playlist();

        // Creamos el formulario
        $form = $this->createForm(PlaylistType::class, $playlist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Obtenemos el usuario actual
            $repository = $entityManager->getRepository(Usuario::class);
            $usuarioEncontrado = $repository->buscarUsuario(1);

            $playlist->setUsuarioPropietario($usuarioEncontrado);

            // Inicializar reproducciones a 0
            $playlist->setReproducciones(0);

            // Primero persistimos la playlist para que tenga un ID
            $entityManager->persist($playlist);
            $entityManager->flush();

            // Ahora procesamos las canciones seleccionadas
            $canciones = $form->get('canciones')->getData();
            foreach ($canciones as $cancion) {
                $playlistCancion = new PlaylistCancion();
                $playlistCancion->setPlaylist($playlist);
                $playlistCancion->setCancion($cancion);
                $playlistCancion->setReproducciones(0); // Inicialmente 0 reproducciones

                $entityManager->persist($playlistCancion);
            }

            // Hacemos un segundo flush para guardar las relaciones
            $entityManager->flush();

            // Redireccionar o mostrar mensaje de éxito
            $this->addFlash('success', 'Playlist creada correctamente con ' . count($canciones) . ' canciones.');

            // Ajusta esta ruta a la que quieras usar para redireccionar
            return $this->redirectToRoute('app_playlist');
        }

        return $this->render('playlist/crearPlaylist.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
