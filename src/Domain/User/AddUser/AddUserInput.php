<?php

namespace App\Domain\User\AddUser;

use App\Domain\Entity\Client;

class AddUserInput
{
    /**
     * @var string
     */
    protected $firstName;
    /**
     * @var string
     */
    protected $lastName;
    /**
     * @var string
     */
    protected $phoneNumber;
    /**
     * @var string
     */
    protected $email;
    /**
     * @var Client
     */
    protected $client;


    //GETTER
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
    public function getClient(): client
    {
        return $this->client;
    }

    //SETTER
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    public function setClient(Client $client): void
    {
        $this->client = $client;
    }
}
