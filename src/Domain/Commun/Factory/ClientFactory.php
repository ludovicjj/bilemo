<?php

namespace App\Domain\Commun\Factory;

use App\Domain\Entity\Client;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ClientFactory
{
    /** @var UserPasswordEncoderInterface  */
    protected $passwordEncoder;

    /**
     * ClientFactory constructor.
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder
    )
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $email
     *
     * @return Client
     *
     * @throws \Exception
     */
    public function create(
        string $username,
        string $password,
        string $email
    )
    {
        $client = new Client();
        $client->createClient(
            $username,
            $this->passwordEncoder->encodePassword($client, $password),
            $email
        );

        return $client;
    }
}