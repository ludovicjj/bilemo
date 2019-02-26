<?php

namespace App\Domain\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use JMS\Serializer\Annotation as JMS;

/**
 * Class User
 * @package App\Domain\Entity
 * @JMS\ExclusionPolicy("all")
 */
class User
{
    /**
     * @var UuidInterface
     * @JMS\Expose()
     * @JMS\Type("string")
     * @JMS\Groups({"list_user", "details_user"})
     */
    protected $id;

    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Groups({"list_user", "details_user"})
     */
    protected $firstName;

    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Groups({"list_user", "details_user"})
     */
    protected $lastName;

    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Groups({"details_user"})
     */
    protected $phoneNumber;

    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Groups({"details_user"})
     */
    protected $email;

    /**
     * @var \DateTime
     * @JMS\Expose()
     * @JMS\Type("DateTime<'Y-m-d'>")
     * @JMS\Groups({"details_user"})
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @JMS\Expose()
     * @JMS\Groups({"details_user"})
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

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getClient(): Client
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