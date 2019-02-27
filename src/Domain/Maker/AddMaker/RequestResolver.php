<?php

namespace App\Domain\Maker\AddMaker;

use App\Domain\Commun\Factory\ErrorsValidationFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestResolver
{
    /** @var SerializerInterface  */
    protected $serializer;

    /** @var ValidatorInterface  */
    protected $validator;

    /**
     * RequestResolver constructor.
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
     * @return object
     * @throws \App\Domain\Commun\Exceptions\ValidatorException
     */
    public function resolve(Request $request)
    {
        // Deserialization
        $input = $this->serializer->deserialize(
            $request->getContent(),
            AddMakerInput::class,
            'json'
        );

        //Validation de AddMakerInput
        $constraintList = $this->validator->validate($input);

        //Traitement des erreurs
        ErrorsValidationFactory::buildError($constraintList);

        return $input;
    }
}