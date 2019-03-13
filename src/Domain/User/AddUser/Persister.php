<?php

namespace App\Domain\User\AddUser;

use App\Domain\Commun\Factory\ErrorsValidationFactory;
use App\Domain\Commun\Factory\UserFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Persister
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var ValidatorInterface  */
    protected $validator;

    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    )
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    /**
     * @param AddUserInput $input
     *
     * @return array
     *
     * @throws \Exception
     */
    public function persist(AddUserInput $input)
    {
        $user = UserFactory::create(
            $input->getFirstName(),
            $input->getLastName(),
            $input->getPhoneNumber(),
            $input->getEmail(),
            $input->getClient()
        );

        $constraintList = $this->validator->validate($user);
        ErrorsValidationFactory::buildError($constraintList);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return [
            'location' => sprintf('http://127.0.0.1:8000/api/clients/%s/users/%s',$user->getClient()->getId(), $user->getId())
        ];
    }
}