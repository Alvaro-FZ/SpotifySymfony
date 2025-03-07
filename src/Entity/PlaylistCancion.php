<?php

namespace App\Entity;

use App\Repository\PlaylistCancionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistCancionRepository::class)]
class PlaylistCancion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'playlistCancions')]
    private ?Playlist $playlist = null;

    #[ORM\ManyToOne(inversedBy: 'playlistCancions')]
    private ?Cancion $cancion = null;

    #[ORM\Column]
    private ?int $reproducciones = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlaylist(): ?Playlist
    {
        return $this->playlist;
    }

    public function setPlaylist(?Playlist $playlist)
    {
        $this->playlist = $playlist;

        return $this;
    }

    public function getCancion(): ?Cancion
    {
        return $this->cancion;
    }

    public function setCancion(?Cancion $cancion)
    {
        $this->cancion = $cancion;

        return $this;
    }

    public function getReproducciones(): ?int
    {
        return $this->reproducciones;
    }

    public function setReproducciones(int $reproducciones)
    {
        $this->reproducciones = $reproducciones;

        return $this;
    }

    public function cogerID()
    {
        return $this->getId(); 
    }
    public function __toString()
    {
        return $this->getCancion()->getTitulo(); 

    }

    public function nombre()
    {
        return $this->getPlaylist()->getNombre(); 

    }
    
    
}
