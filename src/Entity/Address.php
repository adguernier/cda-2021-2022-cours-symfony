<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"address"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=21, nullable=true)
     * @Groups({"address"})
     */
    private $lon;

    /**
     * @ORM\Column(type="string", length=21, nullable=true)
     * @Groups({"address"})
     */
    private $lat;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"address"})
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"address"})
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=9)
     * @Groups({"address"})
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     * @Groups({"address"})
     */
    private $streetNumber;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="address")
     * @Groups({"annonce"})
     */
    private $annonce;

    public function __construct()
    {
        $this->annonce = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLon(): ?string
    {
        return $this->lon;
    }

    public function setLon(?string $lon): self
    {
        $this->lon = $lon;

        return $this;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(?string $lat): self
    {
        $this->lat = $lat;

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

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getStreetNumber(): ?string
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(?string $streetNumber): self
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    /**
     * @return Collection|Annonce[]
     */
    public function getAnnonce(): Collection
    {
        return $this->annonce;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonce->contains($annonce)) {
            $this->annonce[] = $annonce;
            $annonce->setAddress($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonce->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getAddress() === $this) {
                $annonce->setAddress(null);
            }
        }

        return $this;
    }
}
