<?php

namespace App\Entity;

use App\Repository\AxisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AxisRepository::class)]
class Axis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\OneToMany(mappedBy: 'axis', targetEntity: Category::class)]
    private Collection $Categories;

    public function __construct()
    {
        $this->Categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->Categories;
    }

    public function addCategory(Category $Category): self
    {
        if (!$this->Categories->contains($Category)) {
            $this->Categories->add($Category);
            $Category->setAxis($this);
        }

        return $this;
    }

    public function removeCategory(Category $Category): self
    {
        if ($this->Categories->removeElement($Category)) {
            // set the owning side to null (unless already changed)
            if ($Category->getAxis() === $this) {
                $Category->setAxis(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->label;
    }
}
