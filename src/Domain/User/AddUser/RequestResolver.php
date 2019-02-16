<?php

namespace App\Domain\User\AddUser;

use App\Domain\Commun\Factory\ErrorsValidationFactory;
use App\Domain\Entity\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestResolver
{
    /** @var TokenStorageInterface */
    protected $tokenStorage;

    /** @var ValidatorInterface */
    protected $validator;

    /** @var SerializerInterface */
    protected $serializer;

    /**
     * RequestResolver constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     * @param ValidatorInterface $validator
     * @param SerializerInterface $serializer
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        ValidatorInterface $validator,
        SerializerInterface $serializer
    )
    {
        $this->tokenStorage = $tokenStorage;
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    public function resolve(Request $request): AddUserInput
    {
        //TODO Current client
        /** @var Client $client */
        $client = $this->tokenStorage->getToken()->getUser();

        /** @var AddUserInput $input */
        $input = $this->serializer->deserialize(
            $request->getContent(),
            AddUserInput::class,
            'json'
        );

        $input->setClient($client);

        //TODO Validation AddUserInput
        $constraintList = $this->validator->validate($input);
        ErrorsValidationFactory::buildError($constraintList);

        return $input;
    }
}