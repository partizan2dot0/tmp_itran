<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Self_;

/**
 * @ORM\Table(name="tblProductData")
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    public const MIN_COST = 5;

    public const MAX_COST = 1000;

    public const MIN_STOCK = 10;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="intProductDataId", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="strProductName", type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(name="strProductCode", type="string", length=10, unique=true)
     */
    private $code;

    /**
     * @ORM\Column(name="strProductDesc", type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(name="intStock", type="integer", nullable=true)
     */
    private $stock;

    /**
     * @ORM\Column(name="floatCost", type="float", nullable=true)
     */
    private $cost;

    /**
     * @ORM\Column(name="dtmDiscontinued", type="datetime", nullable=true)
     */
    private $discontinued;

    /**
     * @ORM\Column(name="dtmAdded", type="datetime", nullable=true)
     */
    private $added;

    /**
     * @ORM\Column(name="stmTimestamp", type="datetime", nullable=true)
     */
    private $updated;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    private function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    private function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    private function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    private function setStock(?int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getCost(): ?float
    {
        return $this->cost;
    }

    private function setCost(?float $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getDiscontinued(): ?\DateTimeInterface
    {
        return $this->discontinued;
    }

    private function setDiscontinued(string $discontinued): self
    {
        if ($discontinued === 'yes'){
            $this->discontinued = new \DateTimeImmutable('now');     //if discontinued setting current date
        } else {
            $this->discounted = null;
        }

        return $this;
    }

    public function getAdded(): ?\DateTimeInterface
    {
        return $this->added;
    }

    private function setAdded(?\DateTimeInterface $added): self
    {
        $this->added = $added;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    private function setUpdated(?\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    public static function checkConditions(array  $productData): bool  // Import Rules implementation
    {
        if ( ((float)$productData['Cost in GBP'] < self::MIN_COST && (int)$productData['Stock'] < self::MIN_STOCK)
          || ((float)$productData['Cost in GBP'] > self::MAX_COST) ) {
            return true;
        }
        return false;
    }

    public function __construct(array $productData)
    {
        $now = new \DateTimeImmutable('now');
        $this->setName($productData['Product Name'])
        ->setCode($productData['Product Code'])
        ->setDescription($productData['Product Description'])
        ->setCost((float)$productData['Cost in GBP'])
        ->setStock((int)$productData['Stock'])
        ->setAdded($now)
        ->setDiscontinued($productData['Discontinued'])
        ->setUpdated($now);
    }


}
