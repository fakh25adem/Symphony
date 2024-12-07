<?php

namespace App\Entity;

use App\Repository\ObjectifEnvironmRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ObjectifEnvironmRepository::class)]
class ObjectifEnvironm
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_fin = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    #[ORM\Column]
    private ?int $pts_cible = null;

    #[ORM\Column(nullable: true)]
    private ?int $pts_cummules = null;

    /**
     * @var Collection<int, ActionEnvironm>
     */
    #[ORM\ManyToMany(targetEntity: ActionEnvironm::class, mappedBy: 'objectifs')]
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

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): static
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getPtsCible(): ?int
    {
        return $this->pts_cible;
    }

    public function setPtsCible(int $pts_cible): static
    {
        $this->pts_cible = $pts_cible;

        return $this;
    }

    public function getPtsCummules(): ?int
    {
        return $this->pts_cummules;
    }

    public function setPtsCummules(?int $pts_cummules): static
    {
        $this->pts_cummules = $pts_cummules;

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
            $action->addObjectif($this);
        }

        return $this;
    }

    public function removeAction(ActionEnvironm $action): static
    {
        if ($this->actions->removeElement($action)) {
            $action->removeObjectif($this);
        }

        return $this;
    }
}
