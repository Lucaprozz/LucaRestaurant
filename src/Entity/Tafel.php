<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TafelRepository")
 */
class Tafel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $personen;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ReservatieTafel", mappedBy="tafel_id")
     */
    private $tafelid;

    public function __construct()
    {
        $this->tafelid = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPersonen(): ?int
    {
        return $this->personen;
    }

    public function setPersonen(int $personen): self
    {
        $this->personen = $personen;

        return $this;
    }

    /**
     * @return Collection|ReservatieTafel[]
     */
    public function getTafelid(): Collection
    {
        return $this->tafelid;
    }

    public function addTafelid(ReservatieTafel $tafelid): self
    {
        if (!$this->tafelid->contains($tafelid)) {
            $this->tafelid[] = $tafelid;
            $tafelid->setTafelId($this);
        }

        return $this;
    }

    public function removeTafelid(ReservatieTafel $tafelid): self
    {
        if ($this->tafelid->contains($tafelid)) {
            $this->tafelid->removeElement($tafelid);
            // set the owning side to null (unless already changed)
            if ($tafelid->getTafelId() === $this) {
                $tafelid->setTafelId(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return strval($this->id);
    }
}
