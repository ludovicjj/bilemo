<?php

namespace App\Domain\Phone\AddPhone;

use App\Domain\Commun\Factory\ErrorsValidationFactory;
use App\Domain\Entity\Maker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestResolver
{
    /** @var TokenStorageInterface  */
    protected $tokenStorage;

    /** @var SerializerInterface  */
    protected $serializer;

    /** @var ValidatorInterface  */
    protected $validator;

    /**
     * RequestResolver constructor.
     * @param TokenStorageInterface $tokenStorage
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    )
    {
        $this->tokenStorage = $tokenStorage;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @param Request $request
     * @return AddPhoneInput
     * @throws \App\Domain\Commun\Exceptions\ValidatorException
     */
    public function resolve(Request $request): AddPhoneInput
    {
        /** @var Maker $maker */
        $maker = $this->tokenStorage->getToken()->getUser();

        /** @var AddPhoneInput $input */
        $input = $this->serializer->deserialize(
            $request->getContent(),
            AddPhoneInput::class,
            'json'
        );

        $input->setMaker($maker);

        //Validation
        $constraintList = $this->validator->validate($input);

        //Traitement des erreurs
        ErrorsValidationFactory::buildError($constraintList);


        return $input;
    }
}