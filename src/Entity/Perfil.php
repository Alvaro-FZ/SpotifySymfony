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

    #[ORM\Column(length: 255)]
    private ?string $foto = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    #[ORM\ManyToOne(inversedBy: 'perfil')]
    private ?Usuario $usuario = null;

    /**
     * @var Collection<int, Estilo>
     */
    #[ORM\OneToMany(targetEntity: Estilo::class, mappedBy: 'perfil')]
    private Collection $estiloMusical;

    public function __construct()
    {
        $this->estiloMusical = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(string $foto): static
    {
        $this->foto = $foto;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * @return Collection<int, Estilo>
     */
    public function getEstiloMusical(): Collection
    {
        return $this->estiloMusical;
    }

    public function addEstiloMusical(Estilo $estiloMusical): static
    {
        if (!$this->estiloMusical->contains($estiloMusical)) {
            $this->estiloMusical->add($estiloMusical);
            $estiloMusical->setPerfil($this);
        }

        return $this;
    }

    public function removeEstiloMusical(Estilo $estiloMusical): static
    {
        if ($this->estiloMusical->removeElement($estiloMusical)) {
            // set the owning side to null (unless already changed)
            if ($estiloMusical->getPerfil() === $this) {
                $estiloMusical->setPerfil(null);
            }
        }

        return $this;
    }
}
