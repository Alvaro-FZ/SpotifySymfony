<?php

namespace App\Entity;

use App\Repository\CancionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CancionRepository::class)]
class Cancion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titulo = null;

    #[ORM\Column]
    private ?int $duracion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $album = null;

    #[ORM\Column(length: 255)]
    private ?string $autor = null;

    #[ORM\ManyToOne(inversedBy: 'canciones')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Estilo $genero = null;

    #[ORM\Column]
    private ?int $likes = null;

    /**
     * @var Collection<int, PlaylistCancion>
     */
    #[ORM\OneToMany(targetEntity: PlaylistCancion::class, mappedBy: 'cancion')]
    private Collection $playlistCancions;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $archivo = null;

    #[ORM\Column(length: 255,nullable:true)]
    private ?string $portada = null;
    

    public function __construct()
    {
        $this->playlistCancions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getDuracion(): ?int
    {
        return $this->duracion;
    }

    public function setDuracion(int $duracion)
    {
        $this->duracion = $duracion;

        return $this;
    }

    public function getAlbum(): ?string
    {
        return $this->album;
    }

    public function setAlbum(?string $album)
    {
        $this->album = $album;

        return $this;
    }

    public function getAutor(): ?string
    {
        return $this->autor;
    }

    public function setAutor(string $autor)
    {
        $this->autor = $autor;

        return $this;
    }

    public function getGenero(): ?Estilo
    {
        return $this->genero;
    }

    public function setGenero(?Estilo $genero)
    {
        $this->genero = $genero;

        return $this;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(int $likes)
    {
        $this->likes = $likes;

        return $this;
    }
    public function getPlaylistCancions(): Collection
    {
        return $this->playlistCancions;
    }

    public function addPlaylistCancion(PlaylistCancion $playlistCancion)
    {
        if (!$this->playlistCancions->contains($playlistCancion)) {
            $this->playlistCancions->add($playlistCancion);
            $playlistCancion->setCancion($this);
        }

        return $this;
    }

    public function removePlaylistCancion(PlaylistCancion $playlistCancion)
    {
        if ($this->playlistCancions->removeElement($playlistCancion)) {
            // set the owning side to null (unless already changed)
            if ($playlistCancion->getCancion() === $this) {
                $playlistCancion->setCancion(null);
            }
        }

        return $this;
    }

   

    public function getarchivo(): ?string
    {
        return $this->archivo;
    }

    public function setarchivo(?string $archivo)
    {
        $this->archivo = $archivo;

        return $this;
    }

    public function getPortada(): ?string
    {
        return $this->portada;
    }

    public function setPortada(string $portada)
    {
        $this->portada = $portada;

        return $this;
    }

    public function __toString()
    {
        return $this->titulo;
    }

  
}
