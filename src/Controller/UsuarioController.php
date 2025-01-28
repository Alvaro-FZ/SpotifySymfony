<?php

namespace App\Controller;

use App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class UsuarioController extends AbstractController
{
    #[Route('/usuario', name: 'app_usuario')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UsuarioController.php',
        ]);
    }

    #[Route('/usuario/new', name: 'app_usuario_crear')]
    public function crearUsuario(EntityManagerInterface $entityManager): JsonResponse
    {
        $usuario = new Usuario();
        $usuario->setEmail("usuario1@ejem.plo");
        $usuario->setPassword("1234");
        $usuario->setNombre("usuario1");

        $fechaNacimiento = \DateTime::createFromFormat('Y-m-d', '2004-05-15');
        $usuario->setFechaNacimiento($fechaNacimiento);

        $entityManager->persist($usuario);
        $entityManager->flush();

        return $this->json([
            'message' => 'Usuario creado correctamente.',
            'usuario' => [
                'email' => $usuario->getEmail(),
                'nombre' => $usuario->getNombre(),
                'fechaNacimiento' => $usuario->getFechaNacimiento()->format('Y-m-d'),
            ],
        ]);
    }
}
