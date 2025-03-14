<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nameP = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $categoryP = null;

    #[ORM\Column]
    private ?float $priceP = null;

    #[ORM\Column]
    private ?int $stockP = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdP = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descriptionP = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageP = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameP(): ?string
    {
        return $this->nameP;
    }

    public function setNameP(string $nameP): static
    {
        $this->nameP = $nameP;

        return $this;
    }

    public function getCategoryP(): ?string
    {
        return $this->categoryP;
    }

    public function setCategoryP(?string $categoryP): static
    {
        $this->categoryP = $categoryP;

        return $this;
    }

    public function getPriceP(): ?float
    {
        return $this->priceP;
    }

    public function setPriceP(float $priceP): static
    {
        $this->priceP = $priceP;

        return $this;
    }

    public function getStockP(): ?int
    {
        return $this->stockP;
    }

    public function setStockP(int $stockP): static
    {
        $this->stockP = $stockP;

        return $this;
    }

    public function getCreatedP(): ?\DateTimeInterface
    {
        return $this->createdP;
    }

    public function setCreatedP(\DateTimeInterface $createdP): static
    {
        $this->createdP = $createdP;

        return $this;
    }

    public function getDescriptionP(): ?string
    {
        return $this->descriptionP;
    }

    public function setDescriptionP(?string $descriptionP): static
    {
        $this->descriptionP = $descriptionP;

        return $this;
    }

    public function getImageP(): ?string
    {
        return $this->imageP;
    }

    public function setImageP(?string $imageP): static
    {
        $this->imageP = $imageP;

        return $this;
    }
}
