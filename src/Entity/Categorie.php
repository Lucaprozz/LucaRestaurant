<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
 */
class Categorie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $omschrijving;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="categorie_id")
     */
    private $categorieid;

    public function __construct()
    {
        $this->categorieid = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOmschrijving(): ?string
    {
        return $this->omschrijving;
    }

    public function setOmschrijving(string $omschrijving): self
    {
        $this->omschrijving = $omschrijving;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getCategorieid(): Collection
    {
        return $this->categorieid;
    }

    public function addCategorieid(Product $categorieid): self
    {
        if (!$this->categorieid->contains($categorieid)) {
            $this->categorieid[] = $categorieid;
            $categorieid->setCategorieId($this);
        }

        return $this;
    }

    public function removeCategorieid(Product $categorieid): self
    {
        if ($this->categorieid->contains($categorieid)) {
            $this->categorieid->removeElement($categorieid);
            // set the owning side to null (unless already changed)
            if ($categorieid->getCategorieId() === $this) {
                $categorieid->setCategorieId(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getOmschrijving();
    }
}
