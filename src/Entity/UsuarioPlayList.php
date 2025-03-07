<?php

namespace App\Entity;

use App\Repository\UsuarioPlayListRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsuarioPlayListRepository::class)]
class UsuarioPlayList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'playlist')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $usuario = null;

    #[ORM\ManyToOne(inversedBy: 'usuario')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PlayList $playlist = null;

    #[ORM\Column]
    private ?int $reproducida = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuario(): ?User
    {
        return $this->usuario;
    }

    public function setUsuario(?User $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getPlaylist(): ?PlayList
    {
        return $this->playlist;
    }

    public function setPlaylist(?PlayList $playlist): static
    {
        $this->playlist = $playlist;

        return $this;
    }

    public function getReproducida(): ?int
    {
        return $this->reproducida;
    }

    public function setReproducida(int $reproducida): static
    {
        $this->reproducida = $reproducida;

        return $this;
    }
}
