<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put", "delete"},
 *     normalizationContext={"groups"={"pizza_listing:read"}},
 *     denormalizationContext={"groups"={"pizza_listing:write"}},
 *     shortName="pizzas",
 *     attributes={
 *          "pagination_items_per_page" = 5
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\PizzaListingRepository")
 * @ApiFilter(BooleanFilter::class, properties={"isActive"})
 * @ApiFilter(SearchFilter::class, properties={"name": "partial"})
 * @ApiFilter(RangeFilter::class, properties={"price"})
 */
class PizzaListing
{
    const INITIAL_KCAL = 120;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"pizza_listing:read", "pizza_listing:write"})
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min=3,
     *     max=50
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Groups({"pizza_listing:read"})
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"pizza_listing:read", "pizza_listing:write"})
     * @Assert\NotBlank()
     * @Assert\GreaterThan(value="0")
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive = true;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Toppings")
     * @Groups({"pizza_listing:read", "pizza_listing:write"})
     */
    private $toppings;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->toppings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Description as text
     *
     * @Groups({"pizza_listing:write"})
     * @SerializedName("description")
     */
    public function setTextDescription(string $description): self
    {
        $this->description = nl2br($description);

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @Groups({"pizza_listing:read"})
     */
    public function getTotalKCal(): int
    {
        $totalKCal = self::INITIAL_KCAL;
        foreach ($this->toppings as $topping) {
            $totalKCal += $topping->getKCal();
        }

        return $totalKCal;
    }

    /**
     * @return Collection|Toppings[]
     */
    public function getToppings(): Collection
    {
        return $this->toppings;
    }

    public function addTopping(Toppings $topping): self
    {
        if (!$this->toppings->contains($topping)) {
            $this->toppings[] = $topping;
        }

        return $this;
    }

    public function removeTopping(Toppings $topping): self
    {
        if ($this->toppings->contains($topping)) {
            $this->toppings->removeElement($topping);
        }

        return $this;
    }
}
