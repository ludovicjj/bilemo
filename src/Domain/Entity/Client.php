<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class Client implements UserInterface
{
    /**
     * @var UuidInterface
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

    protected $users;

    /**
     * Client constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->users = new ArrayCollection();
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $email
     * @throws \Exception
     */
    public function createClient(
        string $username,
        string $password,
        string $email
    )
    {
        $this->username = $username;
        $this->password = $password;
        $this->createdAt = new \DateTime();
        $this->updatedAt = null;
        $this->roles = ['ROLE_USER'];
        $this->email = $email;

    }

    public function getId(): UuidInterface
    {
        return $this->id;
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

    public function getUpdatedAt(): \DateTime
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

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    public function getUsers()
    {
        return $this->users;
    }
}