<?php

namespace App\Domain\Client\AddClient;

class AddClientInput
{
    /** @var string */
    protected $username;

    /** @var string */
    protected $password;

    /** @var string */
    protected $email;

    //GETTER
    public function getUsername(): string
    {
        return $this->username;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function getEmail(): string
    {
        return $this->email;
    }

    //SETTER
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
