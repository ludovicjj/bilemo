<?php

namespace App\Domain\Client\AddClient;

use App\Domain\Commun\Factory\ErrorsValidationFactory;
use App\Domain\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Domain\Commun\Factory\ClientFactory;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class Persister
{
    /** @var EntityManagerInterface  */
    protected $entityManager;

    /** @var ValidatorInterface  */
    protected $validator;

    /** @var EncoderFactoryInterface  */
    protected $encoderFactory;

    /**
     * Persister constructor.
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     * @param EncoderFactoryInterface $encoderFactory
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        EncoderFactoryInterface $encoderFactory
    )
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->encoderFactory = $encoderFactory;
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
        $client = ClientFactory::create(
            $input->getUsername(),
            $this->encoderFactory->getEncoder(Client::class)->encodePassword($input->getPassword(), ''),
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