<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BankCartRepository")
 */
class BankCart
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
    private $accountnr;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bank;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cardnr;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user", inversedBy="userid")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userid_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccountnr(): ?string
    {
        return $this->accountnr;
    }

    public function setAccountnr(string $accountnr): self
    {
        $this->accountnr = $accountnr;

        return $this;
    }

    public function getBank(): ?string
    {
        return $this->bank;
    }

    public function setBank(string $bank): self
    {
        $this->bank = $bank;

        return $this;
    }

    public function getCardnr(): ?string
    {
        return $this->cardnr;
    }

    public function setCardnr(string $cardnr): self
    {
        $this->cardnr = $cardnr;

        return $this;
    }

    public function getUseridId(): ?user
    {
        return $this->userid_id;
    }

    public function setUseridId(?user $userid_id): self
    {
        $this->userid_id = $userid_id;

        return $this;
    }
}
