<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class Maker implements UserInterface
{
    /** @var UuidInterface  */
    protected $id;

    /** @var string */
    protected $username;

    /** @var string */
    protected $password;

    /** @var array  */
    protected $roles;

    /** @var \DateTime  */
    protected $createdAt;

    /** @var null|\DateTime  */
    protected $updatedAt;

    /** @var ArrayCollection  */
    protected $phones;

    /**
     * Maker constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->phones = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->updatedAt = null;
        $this->roles = ['ROLE_MAKER'];
    }

    public function createMaker(
        string $username,
        string $password
    )
    {
        $this->username = $username;
        $this->password = $password;
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

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ? \DateTime
    {
        return $this->updatedAt;
    }

    public function getPhones(): ArrayCollection
    {
        return $this->phones;
    }


    public function getSalt()
    {
        return;
    }

    public function eraseCredentials()
    {
    }
}