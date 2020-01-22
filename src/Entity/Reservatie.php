<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservatieRepository")
 */
class Reservatie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datum_tijd;

    /**
     * @ORM\Column(type="integer")
     */
    private $aantal;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user", inversedBy="userres_id")
     */
    private $user_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user", inversedBy="medewerkerid")
     * @ORM\JoinColumn(nullable=false)
     */
    private $medewerker_id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ReservatieTafel", mappedBy="reservatie_id")
     */
    private $reservatieid;

    public function __construct()
    {
        $this->reservatieid = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatumTijd(): ?\DateTimeInterface
    {
        return $this->datum_tijd;
    }

    public function setDatumTijd(\DateTimeInterface $datum_tijd): self
    {
        $this->datum_tijd = $datum_tijd;

        return $this;
    }

    public function getAantal(): ?int
    {
        return $this->aantal;
    }

    public function setAantal(int $aantal): self
    {
        $this->aantal = $aantal;

        return $this;
    }

    public function getUserId(): ?user
    {
        return $this->user_id;
    }

    public function setUserId(?user $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getMedewerkerId(): ?user
    {
        return $this->medewerker_id;
    }

    public function setMedewerkerId(?user $medewerker_id): self
    {
        $this->medewerker_id = $medewerker_id;

        return $this;
    }

    /**
     * @return Collection|ReservatieTafel[]
     */
    public function getReservatieid(): Collection
    {
        return $this->reservatieid;
    }

    public function addReservatieid(ReservatieTafel $reservatieid): self
    {
        if (!$this->reservatieid->contains($reservatieid)) {
            $this->reservatieid[] = $reservatieid;
            $reservatieid->setReservatieId($this);
        }

        return $this;
    }

    public function removeReservatieid(ReservatieTafel $reservatieid): self
    {
        if ($this->reservatieid->contains($reservatieid)) {
            $this->reservatieid->removeElement($reservatieid);
            // set the owning side to null (unless already changed)
            if ($reservatieid->getReservatieId() === $this) {
                $reservatieid->setReservatieId(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return strval($this->id);
    }
}
