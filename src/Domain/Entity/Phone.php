<?php

namespace App\Domain\Entity;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * Class Phone
 * @package App\Domain\Entity
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "show_phone",
 *          parameters = { "phone_id" = "expr(object.getId())" },
 *          absolute = true
 *      ),
 *     exclusion = @Hateoas\Exclusion(groups={"list_phone"})
 * )
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "show_phone",
 *          parameters = { "phone_id" = "expr(object.getId())" },
 *          absolute = true
 *      ),
 *     exclusion = @Hateoas\Exclusion(groups={"show_phone"})
 * )
 *
 * @Hateoas\Relation(
 *     "maker",
 *     embedded = @Hateoas\Embedded("expr(object.getMaker())"),
 *     exclusion = @Hateoas\Exclusion(groups={"show_phone"})
 * )
 */
class Phone extends AbstractEntity
{
    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Groups({"list_phone", "show_phone"})
     */
    protected $name;

    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Groups({"show_phone"})
     */
    protected $description;

    /**
     * @var float
     * @Serializer\Expose()
     * @Serializer\Groups({"list_phone", "show_phone"})
     */
    protected $price;

    /**
     * @var integer
     * @Serializer\Expose()
     * @Serializer\Groups({"show_phone"})
     */
    protected $stock;

    /**
     * @var \DateTime
     * @Serializer\Expose()
     * @Serializer\Type("DateTime<'Y-m-d'>")
     * @Serializer\Groups({"show_phone"})
     */
    protected $createdAt;

    /**
     * @var null|\DateTime
     * @Serializer\Expose()
     * @Serializer\Type("DateTime<'Y-m-d'>")
     * @Serializer\Groups({"show_phone"})
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
        $this->createdAt = new \DateTime();
        $this->updatedAt = null;
        parent::__construct();
    }

    /**
     * @param string $name
     * @param string $description
     * @param float $price
     * @param int $stock
     * @param Maker $maker
     */
    public function createPhone(
        string $name,
        string $description,
        float $price,
        int $stock,
        Maker $maker
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
        $this->maker = $maker;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function getMaker(): Maker
    {
        return $this->maker;
    }
}
