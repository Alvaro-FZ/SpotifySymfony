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

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $visibilidad = null;

    #[ORM\Column]
    private ?int $likes = null;

    /**
     * @var Collection<int, PlaylistCancion>
     */
    #[ORM\OneToMany(targetEntity: PlaylistCancion::class, mappedBy: 'playlist')]
    private Collection $playlistCancions;

    /**
     * @var Collection<int, UsuarioListenPlaylist>
     */
    #[ORM\OneToMany(targetEntity: UsuarioListenPlaylist::class, mappedBy: 'playlist')]
    private Collection $usuarioListenPlaylists;

    #[ORM\ManyToOne(inversedBy: 'playlists')]
    private ?Usuario $usuarioPropietario = null;

    public function __construct()
    {
        $this->playlistCancions = new ArrayCollection();
        $this->usuarioListenPlaylists = new ArrayCollection();
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

    public function getVisibilidad(): ?string
    {
        return $this->visibilidad;
    }

    public function setVisibilidad(string $visibilidad): static
    {
        $this->visibilidad = $visibilidad;

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

    /**
     * @return Collection<int, UsuarioListenPlaylist>
     */
    public function getUsuarioListenPlaylists(): Collection
    {
        return $this->usuarioListenPlaylists;
    }

    public function addUsuarioListenPlaylist(UsuarioListenPlaylist $usuarioListenPlaylist): static
    {
        if (!$this->usuarioListenPlaylists->contains($usuarioListenPlaylist)) {
            $this->usuarioListenPlaylists->add($usuarioListenPlaylist);
            $usuarioListenPlaylist->setPlaylist($this);
        }

        return $this;
    }

    public function removeUsuarioListenPlaylist(UsuarioListenPlaylist $usuarioListenPlaylist): static
    {
        if ($this->usuarioListenPlaylists->removeElement($usuarioListenPlaylist)) {
            // set the owning side to null (unless already changed)
            if ($usuarioListenPlaylist->getPlaylist() === $this) {
                $usuarioListenPlaylist->setPlaylist(null);
            }
        }

        return $this;
    }

    public function getUsuarioPropietario(): ?Usuario
    {
        return $this->usuarioPropietario;
    }

    public function setUsuarioPropietario(?Usuario $usuarioPropietario): static
    {
        $this->usuarioPropietario = $usuarioPropietario;

        return $this;
    }
}
