<?php

namespace App\Domain\Client\AddClient;

use App\Domain\Commun\Factory\ErrorsValidationFactory;
use App\Domain\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
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

    /** @var UrlGeneratorInterface  */
    protected $urlGenerator;

    /**
     * Persister constructor.
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     * @param EncoderFactoryInterface $encoderFactory
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        EncoderFactoryInterface $encoderFactory,
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->encoderFactory = $encoderFactory;
        $this->urlGenerator = $urlGenerator;
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
            'location' => $this->urlGenerator->generate('api_client_login')
        ];
    }
}