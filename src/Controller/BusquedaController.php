<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use App\Repository\CancionRepository;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;

class BusquedaController extends AbstractController
{
    #[Route('/buscar', name: 'buscar', methods: ['GET'])]
    public function buscar(AuthenticationUtils $authenticationUtils, Request $request, CancionRepository $cancionRepo, PlaylistRepository $playlistRepo, LoggerInterface $logger): JsonResponse
    {
        $query = $request->query->get('q', '');

        if (empty($query)) {
            return new JsonResponse(['canciones' => [], 'playlists' => []]);
        }

        // Obtener los resultados de la base de datos
        $canciones = $cancionRepo->findByTitulo($query);
        $playlists = $playlistRepo->findByNombre($query);

        // Convertir las entidades en arrays serializables
        $cancionesData = array_map(fn($c) => [
            'id' => $c->getId(),
            'titulo' => $c->getTitulo(),
            'archivo' => $c->getArchivo(),
            'portada' => $c->getPortada() ?? 'default.png'
        ], $canciones);

        $playlistsData = array_map(fn($p) => [
            'id' => $p->getId(),
            'nombre' => $p->getNombre(),
            'portada' => $p->getPortada() ?? 'default.png'
        ], $playlists);

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $logger->notice('## Usuario ' . $lastUsername . ' buscó: "' . $query . '"');

        // Enviar la respuesta en formato JSON
        return new JsonResponse([
            'canciones' => $cancionesData,
            'playlists' => $playlistsData
        ]);
    }
}
