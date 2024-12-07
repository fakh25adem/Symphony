<?php

namespace App\Entity;

use App\Repository\ActionEnvironmRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActionEnvironmRepository::class)]
class ActionEnvironm
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?int $impact_carbon = null;

    #[ORM\Column]
    private ?int $points = null;

    #[ORM\ManyToOne(inversedBy: 'actions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategorieAction $categorie = null;

    #[ORM\ManyToOne]
    private ?User $user = null;

    /**
     * @var Collection<int, ObjectifEnvironm>
     */
    #[ORM\ManyToMany(targetEntity: ObjectifEnvironm::class, inversedBy: 'actions')]
    private Collection $objectifs;

    public function __construct()
    {
        $this->objectifs = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getImpactCarbon(): ?int
    {
        return $this->impact_carbon;
    }

    public function setImpactCarbon(int $impact_carbon): static
    {
        $this->impact_carbon = $impact_carbon;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): static
    {
        $this->points = $points;

        return $this;
    }

    public function getCategorie(): ?CategorieAction
    {
        return $this->categorie;
    }

    public function setCategorie(?CategorieAction $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, ObjectifEnvironm>
     */
    public function getObjectifs(): Collection
    {
        return $this->objectifs;
    }

    public function addObjectif(ObjectifEnvironm $objectif): static
    {
        if (!$this->objectifs->contains($objectif)) {
            $this->objectifs->add($objectif);
        }

        return $this;
    }

    public function removeObjectif(ObjectifEnvironm $objectif): static
    {
        $this->objectifs->removeElement($objectif);

        return $this;
    }


}
