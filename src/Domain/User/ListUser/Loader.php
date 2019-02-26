<?php

namespace App\Domain\User\ListUser;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class Loader
{
    /** @var TokenStorageInterface  */
    protected $tokenStorage;

    /** @var ListUserInput  */
    protected $listUserInput;

    /**
     * Loader constructor.
     * @param TokenStorageInterface $tokenStorage
     * @param ListUserInput $listUserInput
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        ListUserInput $listUserInput
    )
    {
        $this->tokenStorage = $tokenStorage;
        $this->listUserInput = $listUserInput;
    }

    /**
     * @return ListUserInput
     */
    public function load(): ListUserInput
    {
        $client = $this->tokenStorage->getToken()->getUser();
        $users = $client->getUsers();
        $this->listUserInput->setUser($users);

        return $this->listUserInput->getInput();
    }
}