<?php

namespace App\Domain\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Phone
{
    /** @var UuidInterface  */
    protected $id;

    /** @var string */
    protected $name;

    /** @var string */
    protected $description;

    /** @var string */
    protected $price;

    /** @var string */
    protected $stock;

    /** @var \DateTime  */
    protected $createdAt;

    /** @var null|\DateTime  */
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
