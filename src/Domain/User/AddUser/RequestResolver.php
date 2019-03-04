<?php

namespace App\Domain\User\AddUser;

use App\Domain\Commun\Factory\ErrorsValidationFactory;
use App\Domain\Entity\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;
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

    protected $security;

    /**
     * RequestResolver constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     * @param ValidatorInterface $validator
     * @param SerializerInterface $serializer
     * @param Security $security
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        ValidatorInterface $validator,
        SerializerInterface $serializer,
        Security $security
    )
    {
        $this->tokenStorage = $tokenStorage;
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->security = $security;
    }

    /**
     * @param Request $request
     *
     * @return AddUserInput
     *
     * @throws \App\Domain\Commun\Exceptions\ValidatorException
     */
    public function resolve(Request $request): AddUserInput
    {
        /** @var Client $client */
        $client = $this->tokenStorage->getToken()->getUser();
        $client_id = $request->attributes->get('client_id');

        //TODO Test si {client_id} est égal à id de current client
        $this->security->isGranted('CLIENT_ADD', $client_id);


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