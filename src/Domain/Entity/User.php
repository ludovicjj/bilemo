<?php

namespace App\Domain\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class User
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
     * @var string
     */
    protected $email;
    /**
     * @var \DateTime
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
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $email
     * @param Client $client
     * @throws \Exception
     */
    public function createUser(
        string $username,
        string $password,
        string $email,
        Client $client
    )
    {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->createdAt = new \DateTime();
        $this->updatedAt = null;
        $this->client = $client;
    }
}