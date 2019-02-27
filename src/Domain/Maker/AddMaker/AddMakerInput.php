<?php

namespace App\Domain\Maker\AddMaker;

class AddMakerInput
{
    /** @var string */
    protected $username;

    /** @var string */
    protected $password;

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}