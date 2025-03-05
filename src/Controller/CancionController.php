<?php

namespace App\Controller;

use App\Entity\Cancion;
use App\Entity\Estilo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class CancionController extends AbstractController
{
    #[Route('/cancion/{songFileName}/play', name: 'play_music', methods: ['GET'])]
    public function playMusic(string $songFileName): Response
    {
        $musicDirectory = $this->getParameter('kernel.project_dir') . '/songs/';
        $filePath = $musicDirectory . $songFileName;
        if (!file_exists($filePath)) {
            return new Response('Archivo no encontrado', 404);
        }

        
        return new BinaryFileResponse($filePath);
    }

    #[Route('/cancion', name: 'app_cancion')]
    public function index(): Response
    {
        return $this->render('cancion/index.html.twig', [
            'controller_name' => 'CancionController',
        ]);
    }

    #[Route('/cancion/new', name: 'app_cancion_crear')]
    public function createCancion(EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Estilo::class);
        $genero = $repository->buscarEstilo("rock");
        
        $cancion = new Cancion();
        $cancion->setGenero($genero);
        $cancion->setTitulo("titulo1");
        $cancion->setDuracion(90);
        $cancion->setAlbum("album1");
        $cancion->setAutor("autor1");
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
                'likes' => $cancion->getLikes(),
            ],
        ]);
    }
}
