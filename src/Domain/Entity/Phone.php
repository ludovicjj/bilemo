<?php

namespace App\Domain\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use JMS\Serializer\Annotation as JMS;

class Phone
{
    /**
     * @var UuidInterface
     * @JMS\Expose()
     * @JMS\Type("string")
     * @JMS\Groups({"list_phone", "details_phone"})
     */
    protected $id;

    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Groups({"list_phone", "details_phone"})
     */
    protected $name;

    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Groups({"details_phone"})
     */
    protected $description;

    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Groups({"list_phone", "details_phone"})
     */
    protected $price;

    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Groups({"details_phone"})
     */
    protected $stock;

    /**
     * @var \DateTime
     * @JMS\Expose()
     * @JMS\Type("DateTime<'Y-m-d'>")
     * @JMS\Groups({"details_phone"})
     */
    protected $createdAt;

    /**
     * @var null|\DateTime
     * @JMS\Expose()
     * @JMS\Type("DateTime<'Y-m-d'>")
     * @JMS\Groups({"details_phone"})
     */
    protected $updatedAt;

    /** @var Maker */
    protected $maker;

    /**
     * Phone constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->createdAt = new \DateTime();
        $this->updatedAt = null;
    }

    /**
     * @param string $name
     * @param string $description
     * @param string $price
     * @param string $stock
     * @param Maker $maker
     */
    public function createPhone(
        string $name,
        string $description,
        string $price,
        string $stock,
        Maker $maker
    )
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
        $this->maker = $maker;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getStock(): string
    {
        return $this->stock;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ? \DateTime
    {
        return $this->updatedAt;
    }

    public function getMaker(): Maker
    {
        return $this->maker;
    }
}
