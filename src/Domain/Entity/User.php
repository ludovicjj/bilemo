<?php

namespace App\Domain\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use JMS\Serializer\Annotation as JMS;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * Class User
 * @package App\Domain\Entity
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "show_user",
 *          parameters = { "client_id" = "expr(object.getClient().getId())", "user_id" = "expr(object.getId())" },
 *          absolute = true
 *      ),
 *     exclusion=@Hateoas\Exclusion(groups={"show_user"})
 * )
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "list_user",
 *          parameters = { "client_id" = "expr(object.getClient().getId())" },
 *          absolute = true
 *      ),
 *     exclusion=@Hateoas\Exclusion(groups={"list_user"})
 * )
 * @Hateoas\Relation(
 *     "delete",
 *     href = @Hateoas\Route(
 *          "delete_user",
 *          parameters = { "client_id" = "expr(object.getClient().getId())", "user_id" = "expr(object.getId())" },
 *          absolute = true
 *     ),
 *     exclusion=@Hateoas\Exclusion(groups={"list_user"})
 * )
 * @Hateoas\Relation(
 *     "add",
 *     href = @Hateoas\Route(
 *          "add_user",
 *          parameters = { "client_id" = "expr(object.getClient().getId())", "user_id" = "expr(object.getId())" },
 *          absolute = true
 *     ),
 *     exclusion=@Hateoas\Exclusion(groups={"list_user"})
 * )
 */
class User
{
    /**
     * @var string|UuidInterface
     * @JMS\Expose()
     * @JMS\Type("string")
     * @JMS\Groups({"list_user", "show_user"})
     */
    protected $id;

    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Groups({"list_user", "show_user"})
     */
    protected $firstName;

    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Groups({"list_user", "show_user"})
     */
    protected $lastName;

    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Groups({"show_user"})
     */
    protected $phoneNumber;

    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Groups({"show_user"})
     */
    protected $email;

    /**
     * @var \DateTime
     * @JMS\Expose()
     * @JMS\Type("DateTime<'Y-m-d'>")
     * @JMS\Groups({"show_user"})
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @JMS\Expose()
     * @JMS\Groups({"show_user"})
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
        $this->id = Uuid::uuid4()->toString();
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

    /**
     * @return UuidInterface|string
     */
    public function getId()
    {
        return is_object($this->id) ? $this->id->toString() : $this->id;
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