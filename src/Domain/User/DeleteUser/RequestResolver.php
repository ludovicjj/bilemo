<?php

namespace App\Domain\User\DeleteUser;

use App\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RequestResolver
{
    /** @var EntityManagerInterface  */
    protected $entityManager;

    /** @var DeleteUserInput  */
    protected $deleteUserInput;

    /**
     * RequestResolver constructor.
     * @param EntityManagerInterface $entityManager
     * @param DeleteUserInput $deleteUserInput
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        DeleteUserInput $deleteUserInput
    )
    {
       $this->entityManager = $entityManager;
       $this->deleteUserInput = $deleteUserInput;
    }

    /**
     * @param Request $request
     * @return DeleteUserInput
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function resolve(Request $request): DeleteUserInput
    {
        $userId = $request->attributes->get('user_id');

        /** @var User $user */
        $user = $this->entityManager->getRepository(User::class)->userExist($userId);

        if (!$user) {
            throw new NotFoundHttpException(sprintf('Aucun utilisateur ne correspond à l\'id : "%s"', $userId));
        }

        $this->deleteUserInput->setUser($user);

        return $this->deleteUserInput->getInput();
    }
}