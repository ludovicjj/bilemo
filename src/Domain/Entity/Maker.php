<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;

class Maker extends AbstractEntity
{
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
     * @throws \Exception
     */
    public function __construct()
    {
        $this->phones = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @param string $name
     */
    public function createMaker(string $name)
    {
        $this->name = $name;
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
