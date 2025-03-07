<?php

namespace App\Entity;

use App\Repository\PerfilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PerfilRepository::class)]
class Perfil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $foto = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descripcion = null;

    /**
     * @var Collection<int, Estilo>
     */
    #[ORM\ManyToMany(targetEntity: Estilo::class, inversedBy: 'perfiles')]
    private Collection $estiloMusicaPreferidos;

    #[ORM\OneToOne(mappedBy: 'perfil', cascade: ['persist', 'remove'])]
    private ?User $usuario = null;

    public function __construct()
    {
        $this->estiloMusicaPreferidos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(?string $foto): static
    {
        $this->foto = $foto;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return Collection<int, Estilo>
     */
    public function getEstiloMusicaPreferidos(): Collection
    {
        return $this->estiloMusicaPreferidos;
    }

    public function addEstiloMusicaPreferido(Estilo $estiloMusicaPreferido): static
    {
        if (!$this->estiloMusicaPreferidos->contains($estiloMusicaPreferido)) {
            $this->estiloMusicaPreferidos->add($estiloMusicaPreferido);
        }

        return $this;
    }

    public function removeEstiloMusicaPreferido(Estilo $estiloMusicaPreferido): static
    {
        $this->estiloMusicaPreferidos->removeElement($estiloMusicaPreferido);

        return $this;
    }

    public function getUsuario(): ?User
    {
        return $this->usuario;
    }

    public function setUsuario(?User $usuario): static
    {
        // unset the owning side of the relation if necessary
        if ($usuario === null && $this->usuario !== null) {
            $this->usuario->setPerfil(null);
        }

        // set the owning side of the relation if necessary
        if ($usuario !== null && $usuario->getPerfil() !== $this) {
            $usuario->setPerfil($this);
        }

        $this->usuario = $usuario;

        return $this;
    }
}
