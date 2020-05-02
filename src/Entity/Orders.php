<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
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
 *     itemOperations={
 *         "get"={
 *             "normalization_context"={"groups"={"orders:read", "orders:item:get"}}
 *         },
 *         "put",
 *         "delete"
 *     },
 *     normalizationContext={"groups"={"orders:read"}},
 *     denormalizationContext={"groups"={"orders:write"}},
 *     attributes={
 *          "pagination_items_per_page" = 5
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\OrdersRepository")
 * @ApiFilter(SearchFilter::class, properties={"clientName": "partial", "status": "exact"})
 * @ApiFilter(RangeFilter::class, properties={"totalPrice"})
 * @ApiFilter(DateFilter::class, properties={"createdAt"})
 */
class Orders
{
    const STATUS_RECEIVED = 1;
    const STATUS_PREPARING = 2;
    const STATUS_ON_WAY = 3;
    const STATUS_DELIVERED = 4;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"orders:read", "orders:write"})
     * @Assert\NotBlank()
     */
    private $clientName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"orders:read", "orders:write"})
     * @Assert\NotBlank()
     */
    private $sendAddress;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PizzaListing")
     * @Groups({"orders:read", "orders:write"})
     */
    private $pizzas;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status = self::STATUS_RECEIVED;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"orders:read"})
     */
    private $createdAt;

    public function __construct()
    {
        $this->pizzas = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    public function setClientName(string $clientName): self
    {
        $this->clientName = $clientName;

        return $this;
    }

    public function getSendAddress(): ?string
    {
        return $this->sendAddress;
    }

    public function setSendAddress(string $sendAddress): self
    {
        $this->sendAddress = $sendAddress;

        return $this;
    }

    /**
     * @Groups({"orders:read"})
     */
    public function getTotalPrice(): ?int
    {
        $total = 0;
        foreach ($this->pizzas as $pizza) {
            $total += $pizza->getPrice();
        }

        return $total;
    }

    /**
     * @return Collection|PizzaListing[]
     */
    public function getPizzas(): Collection
    {
        return $this->pizzas;
    }

    public function addPizza(PizzaListing $pizza): self
    {
        if (!$this->pizzas->contains($pizza)) {
            $this->pizzas[] = $pizza;
        }

        return $this;
    }

    public function removePizza(PizzaListing $pizza): self
    {
        if ($this->pizzas->contains($pizza)) {
            $this->pizzas->removeElement($pizza);
        }

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @Groups({"orders:read"})
     * @SerializedName("status")
     */
    public function getStatusAsString(): ?string
    {
       switch ($this->status) {
           case self::STATUS_RECEIVED:
               return 'Received';
           case self::STATUS_PREPARING:
               return 'Preparing';
           case self::STATUS_ON_WAY:
               return 'On way';
           case self::STATUS_DELIVERED:
               return 'Delivered';
           default:
               return 'Unknown';
       }
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
}
