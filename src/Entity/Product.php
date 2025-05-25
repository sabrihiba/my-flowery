<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, OrderItem>
     */
    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'product')]
    private Collection $orderItems;

    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): static
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems->add($orderItem);
            $orderItem->setProduct($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): static
    {
        if ($this->orderItems->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getProduct() === $this) {
                $orderItem->setProduct(null);
            }
        }

        return $this;
    }
}
