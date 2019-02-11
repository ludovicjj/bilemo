<?php

namespace App\Domain\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Phone
{
    /**
     * @var UuidInterface
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var int
     */
    protected $price;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @param string $name
     * @param string $description
     * @param int $price
     * @throws \Exception
     */
    public function __constructor(
        string $name,
        string $description,
        int $price
    )
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->createdAt = new \DateTime();
        $this->updatedAt = null;
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

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \Datetime
    {
        return $this->updatedAt;
    }
}
