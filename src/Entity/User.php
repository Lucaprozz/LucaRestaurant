<?php
// src/Entity/User.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BankCart", mappedBy="userid_id")
     */
    private $userid;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservatie", mappedBy="user_id")
     */
    private $userres_id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservatie", mappedBy="medewerker_id")
     */
    private $medewerkerid;

    /**
     * @ORM\Column(type="datetime")
     */
    private $last_activity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telnr;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mobilenr;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $insertionname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adres;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $zip;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    public function __construct()
    {
        parent::__construct();
        $this->userid = new ArrayCollection();
        $this->userres_id = new ArrayCollection();
        $this->medewerkerid = new ArrayCollection();
        // your own logic
    }

    /**
     * @return Collection|BankCart[]
     */
    public function getUserid(): Collection
    {
        return $this->userid;
    }

    public function addUserid(BankCart $userid): self
    {
        if (!$this->userid->contains($userid)) {
            $this->userid[] = $userid;
            $userid->setUseridId($this);
        }

        return $this;
    }

    public function removeUserid(BankCart $userid): self
    {
        if ($this->userid->contains($userid)) {
            $this->userid->removeElement($userid);
            // set the owning side to null (unless already changed)
            if ($userid->getUseridId() === $this) {
                $userid->setUseridId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reservatie[]
     */
    public function getUserresId(): Collection
    {
        return $this->userres_id;
    }

    public function addUserresId(Reservatie $userresId): self
    {
        if (!$this->userres_id->contains($userresId)) {
            $this->userres_id[] = $userresId;
            $userresId->setUserId($this);
        }

        return $this;
    }

    public function removeUserresId(Reservatie $userresId): self
    {
        if ($this->userres_id->contains($userresId)) {
            $this->userres_id->removeElement($userresId);
            // set the owning side to null (unless already changed)
            if ($userresId->getUserId() === $this) {
                $userresId->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reservatie[]
     */
    public function getMedewerkerid(): Collection
    {
        return $this->medewerkerid;
    }

    public function addMedewerkerid(Reservatie $medewerkerid): self
    {
        if (!$this->medewerkerid->contains($medewerkerid)) {
            $this->medewerkerid[] = $medewerkerid;
            $medewerkerid->setMedewerkerId($this);
        }

        return $this;
    }

    public function removeMedewerkerid(Reservatie $medewerkerid): self
    {
        if ($this->medewerkerid->contains($medewerkerid)) {
            $this->medewerkerid->removeElement($medewerkerid);
            // set the owning side to null (unless already changed)
            if ($medewerkerid->getMedewerkerId() === $this) {
                $medewerkerid->setMedewerkerId(null);
            }
        }

        return $this;
    }

    public function getLastActivity(): ?\DateTimeInterface
    {
        return $this->last_activity;
    }

    public function setLastActivity(\DateTimeInterface $last_activity): self
    {
        $this->last_activity = $last_activity;

        return $this;
    }

    public function isActiveNow()
    {
        // Delay during which the user will be considered as still active
        $delay = new \DateTime('2 minutes ago');

        return ( $this->getLastActivity() > $delay );
    }

    public function getTelnr(): ?string
    {
        return $this->telnr;
    }

    public function setTelnr(string $telnr): self
    {
        $this->telnr = $telnr;

        return $this;
    }

    public function getMobilenr(): ?string
    {
        return $this->mobilenr;
    }

    public function setMobilenr(string $mobilenr): self
    {
        $this->mobilenr = $mobilenr;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getInsertionname(): ?string
    {
        return $this->insertionname;
    }

    public function setInsertionname(string $insertionname): self
    {
        $this->insertionname = $insertionname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAdres(): ?string
    {
        return $this->adres;
    }

    public function setAdres(string $adres): self
    {
        $this->adres = $adres;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }
}
