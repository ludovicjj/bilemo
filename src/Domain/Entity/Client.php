<?php

namespace App\Domain\Entity;

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
    protected $password;
    protected $createdAt;
    protected $updatedAt;
    protected $roles;

    /**
     * Client constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    public function createClient(
        string $username
    )
    {
        $this->username = $username;
    }

    public function getId()
    {
        return $this->id;
    }
}