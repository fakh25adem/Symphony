<?php

namespace App\Entity;

use App\Repository\CategorieActionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieActionRepository::class)]
class CategorieAction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    /**
     * @var Collection<int, ActionEnvironm>
     */
    #[ORM\OneToMany(targetEntity: ActionEnvironm::class, mappedBy: 'categorie')]
    private Collection $actions;

    public function __construct()
    {
        $this->actions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, ActionEnvironm>
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }

    public function addAction(ActionEnvironm $action): static
    {
        if (!$this->actions->contains($action)) {
            $this->actions->add($action);
            $action->setCategorie($this);
        }

        return $this;
    }

    public function removeAction(ActionEnvironm $action): static
    {
        if ($this->actions->removeElement($action)) {
            // set the owning side to null (unless already changed)
            if ($action->getCategorie() === $this) {
                $action->setCategorie(null);
            }
        }

        return $this;
    }
}
