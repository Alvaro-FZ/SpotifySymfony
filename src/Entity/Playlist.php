<?php

namespace App\Entity;

use App\Repository\PlaylistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistRepository::class)]
class Playlist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $nombre = null;

    #[ORM\Column(length: 20)]
    private ?string $visibilidad = null;

    #[ORM\ManyToOne(inversedBy: 'playlists')]
    private ?User $usuarioPropietario = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $portada = null;

    #[ORM\Column]
    private ?int $likes = null;

    /**
     * @var Collection<int, UsuarioListenPlaylist>
     */
    #[ORM\OneToMany(targetEntity: UsuarioListenPlaylist::class, mappedBy: 'playlist',cascade:["persist","remove"])]
    private Collection $escuchada;

    /**
     * @var Collection<int, PlaylistCancion>
     */
    #[ORM\OneToMany(targetEntity: PlaylistCancion::class, mappedBy: 'playlist',cascade:["persist","remove"])]
    private Collection $playlistCancions;

    public function __construct()
    {
        $this->escuchada = new ArrayCollection();
        $this->playlistCancions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getPortada(): ?string
    {
        return $this->portada;
    }

    public function setPortada(?string $portada): static
    {
        $this->portada = $portada;

        return $this;
    }

    public function getVisibilidad(): ?string
    {
        return $this->visibilidad;
    }

    public function setVisibilidad(string $visibilidad): static
    {
        $this->visibilidad = $visibilidad;

        return $this;
    }

    public function getUsuarioPropietario(): ?User
    {
        return $this->usuarioPropietario;
    }

    public function setUsuarioPropietario(?User $usuarioPropietario): static
    {
        $this->usuarioPropietario = $usuarioPropietario;

        return $this;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): static
    {
        $this->likes = $likes;

        return $this;
    }

    /**
     * @return Collection<int, UsuarioListenPlaylist>
     */
    public function getEscuchada(): Collection
    {
        return $this->escuchada;
    }

    public function addEscuchada(UsuarioListenPlaylist $escuchada): static
    {
        if (!$this->escuchada->contains($escuchada)) {
            $this->escuchada->add($escuchada);
            $escuchada->setPlaylist($this);
        }

        return $this;
    }

    public function removeEscuchada(UsuarioListenPlaylist $escuchada): static
    {
        if ($this->escuchada->removeElement($escuchada)) {
            // set the owning side to null (unless already changed)
            if ($escuchada->getPlaylist() === $this) {
                $escuchada->setPlaylist(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PlaylistCancion>
     */
    public function getPlaylistCancions(): Collection
    {
        return $this->playlistCancions;
    }

    public function addPlaylistCancion(PlaylistCancion $playlistCancion): static
    {
        if (!$this->playlistCancions->contains($playlistCancion)) {
            $this->playlistCancions->add($playlistCancion);
            $playlistCancion->setPlaylist($this);
        }

        return $this;
    }

    public function removePlaylistCancion(PlaylistCancion $playlistCancion): static
    {
        if ($this->playlistCancions->removeElement($playlistCancion)) {
            // set the owning side to null (unless already changed)
            if ($playlistCancion->getPlaylist() === $this) {
                $playlistCancion->setPlaylist(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNombre(); 
    }
}
