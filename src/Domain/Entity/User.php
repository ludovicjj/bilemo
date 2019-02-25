<?php

namespace App\Domain\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class User
 * @package App\Domain\Entity
 * @Serializer\ExclusionPolicy("all")
 */
class User
{
    /**
     * @var UuidInterface
     */
    protected $id;

    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Groups({"list_user", "details_user"})
     */
    protected $firstName;

    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Groups({"list_user", "details_user"})
     */
    protected $lastName;

    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Groups({"details_user"})
     */
    protected $phoneNumber;

    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Groups({"details_user"})
     */
    protected $email;

    /**
     * @var \DateTime
     * @Serializer\Expose()
     * @Serializer\Groups({"details_user"})
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @var Client
     */
    protected $client;

    /**
     * User constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->createdAt = new \DateTime();
        $this->updatedAt = null;
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $phoneNumber
     * @param string $email
     * @param Client $client
     */
    public function createUser(
        string $firstName,
        string $lastName,
        string $phoneNumber,
        string $email,
        Client $client
    )
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
        $this->client = $client;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): ? \DateTime
    {
        return $this->updatedAt;
    }
}