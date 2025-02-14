<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Entity\Perfil;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UsuarioController extends AbstractController
{
    #[Route('/usuario', name: 'app_usuario')]
    public function index(): Response
    {
        return $this->render('usuario/index.html.twig', [
            'controller_name' => 'UsuarioController',
        ]);
    }

    #[Route('/usuario/new', name: 'app_usuario_crear')]
    public function crearUsuario(EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Perfil::class);
        $perfilEncontrado = $repository->buscarPerfil(3);

        $usuario = new Usuario();
        $usuario->setEmail("alvaro@email.clase");
        $usuario->setNombre("alvaro");
        $usuario->setPassword("alvaroPass");
        $usuario->setFechaNacimiento("06/01/2004");
        $usuario->setPerfil($perfilEncontrado);

        $entityManager->persist($usuario);
        $entityManager->flush();

        return $this->json([
            'message' => 'usuario creado correctamente.',
            'usuario' => [
                'email' => $usuario->getEmail(),
                'password' => $usuario->getPassword(),
                'nombre' => $usuario->getNombre(),
                'fechaNacimiento' => $usuario->getFechaNacimiento(),
            ],
        ]);
    }
}
