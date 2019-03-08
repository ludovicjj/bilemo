<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use JMS\Serializer\Annotation as Serializer;

class Maker
{
    /**
     * @var UuidInterface
     * @Serializer\Expose()
     * @Serializer\Type("string")
     * @Serializer\Groups({"show_phone"})
     */
    protected $id;

    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Groups({"show_phone"})
     */
    protected $name;

    /** @var ArrayCollection  */
    protected $phones;

    /**
     * Maker constructor.
     * @param string $name
     * @throws \Exception
     */
    public function __construct(
        string $name
    )
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
        $this->phones = new ArrayCollection();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPhones()
    {
        return $this->phones;
    }
}