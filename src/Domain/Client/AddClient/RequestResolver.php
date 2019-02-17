<?php

namespace App\Domain\Client\AddClient;

use App\Domain\Commun\Factory\ErrorsValidationFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestResolver
{
    /** @var SerializerInterface */
    protected $serializer;

    /** @var ValidatorInterface  */
    protected $validator;

    /**
     * RequestResolver constructor.
     *
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator
    )
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @param Request $request
     *
     * @return AddClientInput
     *
     * @throws \App\Domain\Commun\Exceptions\ValidatorException
     */
    public function resolve(Request $request): AddClientInput
    {
        //TODO Recuperation des données du body de la request
        //TODO Hydratation de AddClientInput
        /** @var AddClientInput $input */
        $input = $this->serializer->deserialize(
            $request->getContent(),
            AddClientInput::class,
            'json'
        );

        //TODO Validation de AddClientInput
        $constraintList = $this->validator->validate($input);
        ErrorsValidationFactory::buildError($constraintList);

        //TODO retourne AddClientInput
        return $input;
    }
}