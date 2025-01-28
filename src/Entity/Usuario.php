<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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

    #[ORM\Column(length: 25)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fechaNacimiento = null;

    /**
     * @var Collection<int, UsuarioPlaylist>
     */
    #[ORM\OneToMany(targetEntity: UsuarioPlaylist::class, mappedBy: 'usuario')]
    private Collection $usuarioPlaylists;

    /**
     * @var Collection<int, Perfil>
     */
    #[ORM\OneToMany(targetEntity: Perfil::class, mappedBy: 'usuario')]
    private Collection $perfil;

    public function __construct()
    {
        $this->usuarioPlaylists = new ArrayCollection();
        $this->perfil = new ArrayCollection();
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

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(\DateTimeInterface $fechaNacimiento): static
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * @return Collection<int, UsuarioPlaylist>
     */
    public function getUsuarioPlaylists(): Collection
    {
        return $this->usuarioPlaylists;
    }

    public function addUsuarioPlaylist(UsuarioPlaylist $usuarioPlaylist): static
    {
        if (!$this->usuarioPlaylists->contains($usuarioPlaylist)) {
            $this->usuarioPlaylists->add($usuarioPlaylist);
            $usuarioPlaylist->setUsuario($this);
        }

        return $this;
    }

    public function removeUsuarioPlaylist(UsuarioPlaylist $usuarioPlaylist): static
    {
        if ($this->usuarioPlaylists->removeElement($usuarioPlaylist)) {
            // set the owning side to null (unless already changed)
            if ($usuarioPlaylist->getUsuario() === $this) {
                $usuarioPlaylist->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Perfil>
     */
    public function getPerfil(): Collection
    {
        return $this->perfil;
    }

    public function addPerfil(Perfil $perfil): static
    {
        if (!$this->perfil->contains($perfil)) {
            $this->perfil->add($perfil);
            $perfil->setUsuario($this);
        }

        return $this;
    }

    public function removePerfil(Perfil $perfil): static
    {
        if ($this->perfil->removeElement($perfil)) {
            // set the owning side to null (unless already changed)
            if ($perfil->getUsuario() === $this) {
                $perfil->setUsuario(null);
            }
        }

        return $this;
    }
}
