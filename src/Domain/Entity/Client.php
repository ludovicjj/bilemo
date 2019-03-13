<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use JMS\Serializer\Annotation as JMS;

/**
 * Class Client
 * @package App\Domain\Entity
 * @JMS\ExclusionPolicy("all")
 */
class Client implements UserInterface
{
    /**
     * @var string|UuidInterface
     */
    protected $id;
    /**
     * @var string
     */
    protected $username;
    /**
     * @var string
     */
    protected $password;
    /**
     * @var \DateTime
     */
    protected $createdAt;
    /**
     * @var \DateTime
     */
    protected $updatedAt;
    /**
     * @var array
     */
    protected $roles;
    /**
     * @var string
     */
    protected $email;

    /**
     * @var ArrayCollection
     * @JMS\Expose()
     * @JMS\Groups({"list_user"})
     */
    protected $users;

    /**
     * Client constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
        $this->users = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->updatedAt = null;
        $this->roles = ['ROLE_CLIENT'];
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $email
     */
    public function createClient(
        string $username,
        string $password,
        string $email
    )
    {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }

    /**
     * @return UuidInterface|string
     */
    public function getId()
    {
        return is_object($this->id) ? $this->id->toString() : $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    public function getSalt(): void
    {
        return;
    }

    public function eraseCredentials()
    {
    }
}