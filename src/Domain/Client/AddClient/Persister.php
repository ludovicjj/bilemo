<?php

namespace App\Domain\Client\AddClient;

use App\Domain\Commun\Factory\ClientFactory;
use App\Domain\Commun\Factory\ErrorsValidationFactory;
use App\Domain\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Persister
{
    /** @var EntityManagerInterface  */
    protected $entityManager;

    /** @var ClientFactory  */
    protected $clientFactory;

    /** @var ValidatorInterface  */
    protected $validator;

    /**
     * Persister constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param ClientFactory $clientFactory
     * @param ValidatorInterface $validator
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ClientFactory $clientFactory,
        ValidatorInterface $validator
    )
    {
        $this->entityManager = $entityManager;
        $this->clientFactory = $clientFactory;
        $this->validator = $validator;
    }

    /**
     * @param AddClientInput $input
     * @return array
     * @throws \App\Domain\Commun\Exceptions\ValidatorException
     * @throws \Exception
     */
    public function persist(AddClientInput $input): array
    {
        /** @var Client $client */
        $client = $this->clientFactory->create(
            $input->getUsername(),
            $input->getPassword(),
            $input->getEmail()
        );

        $constraintList = $this->validator->validate($client);
        ErrorsValidationFactory::buildError($constraintList);

        $this->entityManager->persist($client);
        $this->entityManager->flush();

        return [
            'location' => sprintf('http://127.0.0.1:8000/api/clients/%s', $client->getId())
        ];
    }
}