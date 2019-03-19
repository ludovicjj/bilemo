<?php

namespace App\Domain\User\ListUser;

use App\Domain\Commun\Exceptions\ProcessorErrorsHttp;
use App\Domain\Entity\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;

class Loader
{
    /** @var TokenStorageInterface  */
    protected $tokenStorage;

    /** @var ListUserInput  */
    protected $listUserInput;

    /** @var Security  */
    protected $security;

    /**
     * Loader constructor.
     * @param TokenStorageInterface $tokenStorage
     * @param ListUserInput $listUserInput
     * @param Security $security
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        ListUserInput $listUserInput,
        Security $security
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->listUserInput = $listUserInput;
        $this->security = $security;
    }

    /**
     * @param Request $request
     * @return ListUserInput
     */
    public function load(Request $request): ListUserInput
    {
        $clientId = $request->attributes->get('client_id');

        /** @var TokenInterface|null $token */
        $token = $this->tokenStorage->getToken();

        /** @var Client|string $client */
        $client = !is_null($token) ? $token->getUser() : null;

        if (!$this->security->isGranted('CLIENT_CHECK', $clientId)) {
            ProcessorErrorsHttp::throwAccessDenied('Vous n\'êtes pas autorisé à consulter ce catalogue d\'utilisateur');
        }

        $users = $client->getUsers();
        $this->listUserInput->setUser($users);

        return $this->listUserInput->getInput();
    }
}
