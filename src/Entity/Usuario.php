<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
class Usuario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $fechaNacimiento = null;

    /**
     * @var Collection<int, UsuarioListenPlaylist>
     */
    #[ORM\OneToMany(targetEntity: UsuarioListenPlaylist::class, mappedBy: 'usuario')]
    private Collection $usuarioListenPlaylists;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Perfil $perfil = null;

    /**
     * @var Collection<int, Playlist>
     */
    #[ORM\OneToMany(targetEntity: Playlist::class, mappedBy: 'usuarioPropietario')]
    private Collection $playlists;

    public function __construct()
    {
        $this->usuarioListenPlaylists = new ArrayCollection();
        $this->playlists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
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

    public function getFechaNacimiento(): ?string
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(string $fechaNacimiento): static
    {
        $this->fechaNacimiento = $fechaNacimiento;

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
            $usuarioListenPlaylist->setUsuario($this);
        }

        return $this;
    }

    public function removeUsuarioListenPlaylist(UsuarioListenPlaylist $usuarioListenPlaylist): static
    {
        if ($this->usuarioListenPlaylists->removeElement($usuarioListenPlaylist)) {
            // set the owning side to null (unless already changed)
            if ($usuarioListenPlaylist->getUsuario() === $this) {
                $usuarioListenPlaylist->setUsuario(null);
            }
        }

        return $this;
    }

    public function getPerfil(): ?Perfil
    {
        return $this->perfil;
    }

    public function setPerfil(?Perfil $perfil)
    {
        $this->perfil = $perfil;

        return $this;
    }

    /**
     * @return Collection<int, Playlist>
     */
    public function getPlaylists(): Collection
    {
        return $this->playlists;
    }

    public function addPlaylist(Playlist $playlist): static
    {
        if (!$this->playlists->contains($playlist)) {
            $this->playlists->add($playlist);
            $playlist->setUsuarioPropietario($this);
        }

        return $this;
    }

    public function removePlaylist(Playlist $playlist): static
    {
        if ($this->playlists->removeElement($playlist)) {
            // set the owning side to null (unless already changed)
            if ($playlist->getUsuarioPropietario() === $this) {
                $playlist->setUsuarioPropietario(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNombre();
    }
}
