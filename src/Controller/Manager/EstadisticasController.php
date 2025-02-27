<?php

namespace App\Controller\Manager;

use App\Repository\PlaylistCancionRepository;
use App\Repository\PlaylistRepository;
use App\Repository\UserRepository;
use App\Repository\EstiloRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/manager')]
#[IsGranted('ROLE_MANAGER')]
class EstadisticasController extends AbstractController
{
    #[Route('/estadisticas', name: 'estadisticas')]
    public function index(PlaylistCancionRepository
    $playlistCancionRepository): Response
    {
        // Obtener datos de reproducciones por playlist
        $datos = $playlistCancionRepository->obtenerReproduccionesPorPlaylist();
        return $this->render('estadisticas/index.html.twig', [
            'datos' => $datos
        ]);
    }

    #[Route('/estadisticas/datos', name: 'estadisticas_datos')]
    public function obtenerDatos(PlaylistCancionRepository $playlistCancionRepository): JsonResponse
    {
        $datos = $playlistCancionRepository->obtenerReproduccionesPorPlaylist();
        return $this->json($datos); // convierte el array $datos en una respuesta JSON.
    }

    #[Route('/estadisticas/likes', name: 'estadisticas_likes')]
    public function obtenerLikes(PlaylistRepository $playlistRepository): JsonResponse
    {
        $datos = $playlistRepository->obtenerLikesPlaylist();
        return $this->json($datos); // convierte el array $datos en una respuesta JSON.
    }

    #[Route('/estadisticas/usuarios', name: 'estadisticas_usuarios')]
    public function obtenerUsuarios(UserRepository $userRepository): JsonResponse
    {
        $datos = $userRepository->obtenerUsuariosRegistrados();
        return $this->json($datos); // convierte el array $datos en una respuesta JSON.
    }

    #[Route('/estadisticas/estilos', name: 'estadisticas_estilos')]
    public function obtenerEstilos(EstiloRepository $estiloRepository): JsonResponse
    {
        $datos = $estiloRepository->obtenerEstilosPorUsuario();
        return $this->json($datos); // convierte el array $datos en una respuesta JSON.
    }
}
