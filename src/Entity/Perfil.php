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

    /**
     * @var Collection<int, Estilo>
     */
    #[ORM\ManyToMany(targetEntity: Estilo::class, inversedBy: 'perfils')]
    private Collection $estilosMusicalPreferidos;

    public function __construct()
    {
        $this->estilosMusicalPreferidos = new ArrayCollection();
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

    /**
     * @return Collection<int, Estilo>
     */
    public function getEstilosMusicalPreferidos(): Collection
    {
        return $this->estilosMusicalPreferidos;
    }

    public function addEstilosMusicalPreferido(Estilo $estilosMusicalPreferido)
    {
        if (!$this->estilosMusicalPreferidos->contains($estilosMusicalPreferido)) {
            $this->estilosMusicalPreferidos->add($estilosMusicalPreferido);
        }

        return $this;
    }

    public function removeEstilosMusicalPreferido(Estilo $estilosMusicalPreferido)
    {
        $this->estilosMusicalPreferidos->removeElement($estilosMusicalPreferido);

        return $this;
    }
}
