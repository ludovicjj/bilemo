<?php

namespace App\Domain\Client\AddClient;

use App\Domain\Commun\Factory\ClientFactory;
use App\Domain\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;

class Persister
{
    /** @var EntityManagerInterface  */
    protected $entityManager;

    /** @var ClientFactory  */
    protected $clientFactory;

    /**
     * Persister constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param ClientFactory $clientFactory
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ClientFactory $clientFactory
    )
    {
        $this->entityManager = $entityManager;
        $this->clientFactory = $clientFactory;
    }

    /**
     * @param AddClientInput $input
     *
     * @return array
     *
     * @throws \Exception
     */
    public function persist(AddClientInput $input): array
    {
        //TODO hydratation de l'entité Client
        //TODO Hash du password du Client
        /** @var Client $client */
        $client = $this->clientFactory->create(
            $input->getUsername(),
            $input->getPassword(),
            $input->getEmail()
        );

        //TODO persist et flush de l'entité Client
        $this->entityManager->persist($client);
        $this->entityManager->flush();

        return [
            'location' => sprintf('http://127.0.0.1:8000/api/clients/%s', $client->getId())
        ];
    }
}