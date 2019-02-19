<?php

namespace App\Domain\User\ListUser;

use App\Domain\Entity\Client;
use App\Domain\Repository\UserRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;

class Loader
{
    /** @var UserRepository  */
    protected $userRepository;

    /** @var TokenStorageInterface  */
    protected $tokenStorage;

    /** @var SerializerInterface  */
    protected $serializer;

    public function __construct(
        UserRepository $userRepository,
        TokenStorageInterface $tokenStorage,
        SerializerInterface $serializer
    )
    {
        $this->userRepository = $userRepository;
        $this->tokenStorage = $tokenStorage;
        $this->serializer = $serializer;
    }

    public function load(): string
    {
        //TODO Recuperation du current client
        /** @var Client $client */
        $client = $this->tokenStorage->getToken()->getUser();

        //TODO Recuperation de l'id du client
        $clientId = $client->getId()->toString();

        //TODO Recuperation des users correspondant à client_id
        $users = $this->userRepository->findUserbyClientId($clientId);

        //TODO transforme object en string, format : json
        $datas = $this->serializer->serialize($users, 'json', []);


        return $datas;
    }
}