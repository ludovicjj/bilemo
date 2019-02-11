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


    public function addPhone(Phone $phone)
    {
        $phone->definedMaker($this);
        $this->phones[] = $phone;
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