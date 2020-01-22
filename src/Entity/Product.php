<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
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
     * @ORM\Column(type="float")
     */
    private $prijs;

    /**
     * @ORM\Column(type="integer")
     */
    private $voorraad;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="categorieid")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie_id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Menu", mappedBy="product_id")
     */
    private $productid;

    public function __construct()
    {
        $this->productid = new ArrayCollection();
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

    public function getPrijs(): ?float
    {
        return $this->prijs;
    }

    public function setPrijs(float $prijs): self
    {
        $this->prijs = $prijs;

        return $this;
    }

    public function getVoorraad(): ?int
    {
        return $this->voorraad;
    }

    public function setVoorraad(int $voorraad): self
    {
        $this->voorraad = $voorraad;

        return $this;
    }

    public function getCategorieId(): ?categorie
    {
        return $this->categorie_id;
    }

    public function setCategorieId(?categorie $categorie_id): self
    {
        $this->categorie_id = $categorie_id;

        return $this;
    }

    /**
     * @return Collection|Menu[]
     */
    public function getProductid(): Collection
    {
        return $this->productid;
    }

    public function addProductid(Menu $productid): self
    {
        if (!$this->productid->contains($productid)) {
            $this->productid[] = $productid;
            $productid->setProductId($this);
        }

        return $this;
    }

    public function removeProductid(Menu $productid): self
    {
        if ($this->productid->contains($productid)) {
            $this->productid->removeElement($productid);
            // set the owning side to null (unless already changed)
            if ($productid->getProductId() === $this) {
                $productid->setProductId(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getOmschrijving();
    }
}
