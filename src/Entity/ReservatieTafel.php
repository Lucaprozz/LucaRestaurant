<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservatieTafelRepository")
 */
class ReservatieTafel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\reservatie", inversedBy="reservatieid")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reservatie_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tafel", inversedBy="tafelid")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tafel_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReservatieId(): ?reservatie
    {
        return $this->reservatie_id;
    }

    public function setReservatieId(?reservatie $reservatie_id): self
    {
        $this->reservatie_id = $reservatie_id;

        return $this;
    }

    public function getTafelId(): ?tafel
    {
        return $this->tafel_id;
    }

    public function setTafelId(?tafel $tafel_id): self
    {
        $this->tafel_id = $tafel_id;

        return $this;
    }
}
