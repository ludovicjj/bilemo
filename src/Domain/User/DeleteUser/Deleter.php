<?php

namespace App\Domain\User\DeleteUser;

use App\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class Deleter
{
    /** @var EntityManagerInterface  */
    protected $entityManager;

    /**
     * Persister constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param DeleteUserInput $input
     */
    public function delete(DeleteUserInput $input): void
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $input->getUser()->getId()->toString()]);
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}