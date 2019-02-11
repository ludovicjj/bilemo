<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Maker
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
     * @var ArrayCollection
     */
    protected $phones;

    /**
     * Maker constructor.
     * @param string $name
     * @param array $phones
     * @throws \Exception
     */
    public function __construct(
        string $name,
        array $phones = []
    )
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
        $this->phones = new ArrayCollection($phones);
    }

    /**
     * @param array $phones
     */
    public function addPhone(array $phones)
    {
        // Defined Maker for each phone
        foreach ($phones as $phone) {
            $phone->definedMaker($this);
            $this->phones[] = $phone;
        }
    }

    /**
     * @param array $phones
     */
    public function removePhone(array $phones)
    {
        // Delete phones in ArrayCollection
        foreach ($phones as $phone) {
            $this->phones->removeElement($phone);
        }
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}