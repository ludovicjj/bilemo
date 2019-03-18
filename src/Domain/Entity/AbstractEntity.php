<?php

namespace App\Domain\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use JMS\Serializer\Annotation as JMS;

/**
 * Class AbstractEntity
 * @package App\Domain\Entity
 * @JMS\ExclusionPolicy("all")
 */
abstract class AbstractEntity
{
    /**
     * @var string|UuidInterface
     * @JMS\Expose()
     * @JMS\Type("string")
     * @JMS\Groups({"list_user", "show_user", "list_phone", "show_phone"})
     */
    protected $id;

    /**
     * AbstractEntity constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
    }

    /**
     * @return UuidInterface|string
     */
    public function getId()
    {
        return is_object($this->id) ? $this->id->toString() : $this->id;
    }
}
