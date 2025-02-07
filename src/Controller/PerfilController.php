<?php

namespace App\Controller;

use App\Entity\Perfil;
use App\Entity\Estilo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PerfilController extends AbstractController
{
    #[Route('/perfil', name: 'app_perfil')]
    public function index(): Response
    {
        return $this->render('perfil/index.html.twig', [
            'controller_name' => 'PerfilController',
        ]);
    }
    
    #[Route('/perfil/new', name: 'app_perfil_crear')]
    public function crearPerfil(EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Estilo::class);
        $estilo = $repository->buscarEstilo("rock");

        $perfil = new Perfil();
        $perfil->setFoto("iasduihasih");
        $perfil->setDescripcion("Perfil 1");
        $perfil->addEstilosMusicalPreferido($estilo);

        $entityManager->persist($perfil);
        $entityManager->flush();

        return $this->json([
            'message' => 'perfil creado correctamente.',
            'perfil' => [
                'foto' => $perfil->getFoto(),
                'descripcion' => $perfil->getDescripcion(),
            ],
        ]);
    }

}
