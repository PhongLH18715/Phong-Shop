<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarRepository::class)
 */
class Car
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Name;

    /**
     * @ORM\ManyToOne(targetEntity=Manufacturer::class, inversedBy="cars")
     */
    private $Manufacturer;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Price;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Description;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $YearOfManufacture;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Amount;

    /**
     * @ORM\ManyToOne(targetEntity=CarTypes::class, inversedBy="cars")
     */
    private $CarType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Image;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(?string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getManufacturer(): ?Manufacturer
    {
        return $this->Manufacturer;
    }

    public function setManufacturer(?Manufacturer $Manufacturer): self
    {
        $this->Manufacturer = $Manufacturer;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->Price;
    }

    public function setPrice(?int $Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getYearOfManufacture(): ?\DateTimeInterface
    {
        return $this->YearOfManufacture;
    }

    public function setYearOfManufacture(?\DateTimeInterface $YearOfManufacture): self
    {
        $this->YearOfManufacture = $YearOfManufacture;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->Amount;
    }

    public function setAmount(?int $Amount): self
    {
        $this->Amount = $Amount;

        return $this;
    }

    public function getCarType(): ?CarTypes
    {
        return $this->CarType;
    }

    public function setCarType(?CarTypes $CarType): self
    {
        $this->CarType = $CarType;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(?string $Image): self
    {
        $this->Image = $Image;

        return $this;
    }
}
