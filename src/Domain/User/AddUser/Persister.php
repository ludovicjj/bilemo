<?php

namespace App\Domain\User\AddUser;

use App\Domain\Commun\Factory\UserFactory;
use Doctrine\ORM\EntityManagerInterface;

class Persister
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
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

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return [
            'location' => sprintf('http://127.0.0.1:8000/api/clients/%s/users/%s',$user->getClient()->getId(), $user->getId())
        ];
    }
}