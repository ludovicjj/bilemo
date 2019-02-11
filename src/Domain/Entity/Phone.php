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
     * @var Maker
     */
    protected $maker;

    /**
     * Phone constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    /**
     * @param string $name
     * @param string $description
     * @param int $price
     * @param Maker $maker
     * @throws \Exception
     */
    public function createPhone(
        string $name,
        string $description,
        int $price,
        Maker $maker
    )
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->createdAt = new \DateTime();
        $this->maker = $maker;
    }

    /**
     * @param string $name
     * @param string $description
     * @param int $price
     * @throws \Exception
     */
    public function updatePhone(
        string $name,
        string $description,
        int $price
    )
    {
        $this->name =$name;
        $this->description = $description;
        $this->price = $price;
        $this->updatedAt = new \DateTime();
    }
}
